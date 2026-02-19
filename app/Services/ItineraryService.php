<?php

namespace App\Services;

use App\Models\Partner;
use App\Models\Trip;
use Illuminate\Support\Facades\Log;
use OpenAI\Laravel\Facades\OpenAI;

class ItineraryService
{
    public function generate(Trip $trip): array
    {
        $trip->loadMissing(['island', 'city.gems', 'budgetLevel', 'categories']);

        $prompt = $this->buildPrompt($trip);

        $response = OpenAI::chat()->create([
            'model'       => 'gpt-4o-mini',
            'messages'    => [
                ['role' => 'system', 'content' => 'You are a travel planner expert for the Azores islands (Portugal). You always respond with valid JSON only, no extra text.'],
                ['role' => 'user', 'content' => $prompt],
            ],
            'temperature' => 0.7,
            'max_tokens'  => 4000,
        ]);

        $content = $response->choices[0]->message->content;

        // Strip markdown code fences if present
        $content = preg_replace('/^```(?:json)?\s*/', '', $content);
        $content = preg_replace('/\s*```$/', '', $content);

        $itinerary = json_decode($content, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            Log::error('ItineraryService: Failed to parse OpenAI response', [
                'trip_id' => $trip->id,
                'error'   => json_last_error_msg(),
                'content' => $content,
            ]);
            throw new \RuntimeException('Failed to parse itinerary from AI response.');
        }

        return $itinerary;
    }

    private function buildPrompt(Trip $trip): string
    {
        $island     = $trip->island->name;
        $city       = $trip->city->name;
        $duration   = $trip->duration_days;
        $adults     = $trip->num_adults;
        $children   = $trip->num_children;
        $hasCar     = $trip->has_car ? 'Sim' : 'Não';
        $budget     = $trip->budgetLevel;
        $budgetName = $budget->name;
        $budgetMin  = $budget->min_budget;
        $budgetMax  = $budget->max_budget ? $budget->max_budget : $budget->min_budget . '+';
        $categories = $trip->categories->pluck('name')->implode(', ');

        // Build hidden gems section
        $gemsSection = '';
        $gems = $trip->city->gems;
        if ($gems->isNotEmpty()) {
            $gemsSection = "\n\nDICAS LOCAIS E HIDDEN GEMS (obrigatório incluir pelo menos 1 por dia):\n";
            foreach ($gems as $gem) {
                $gemsSection .= "- {$gem->name}: {$gem->description}";
                if ($gem->tip) {
                    $gemsSection .= " (Dica: {$gem->tip})";
                }
                $gemsSection .= "\n";
            }
        }

        // Build partners section - match by island + budget level or higher + user categories
        $partnersSection = '';
        $categoryIds = $trip->categories->pluck('id')->toArray();

        $partners = Partner::where('island_id', $trip->island_id)
            ->where('budget_level_id', '<=', $trip->budget_level_id)
            ->whereIn('trip_category_id', $categoryIds)
            ->with(['category', 'budgetLevel'])
            ->get();

        if ($partners->isNotEmpty()) {
            $partnersSection = "\n\nPARCEIROS RECOMENDADOS (incluir quando se enquadram no orçamento e preferências):\n";
            foreach ($partners as $partner) {
                $partnersSection .= "- {$partner->name}: {$partner->description} | Preço: {$partner->price}€ pp | Categoria: {$partner->category->name} | Contacto: {$partner->contact}";
                if ($partner->link) {
                    $partnersSection .= " | Link: {$partner->link}";
                }
                $partnersSection .= "\n";
            }
        }

        $prompt = <<<PROMPT
Gera um itinerário de viagem dia a dia detalhado com base nos seguintes dados:

- Ilha: {$island}
- Cidade do hotel: {$city}
- Duração: {$duration} dias
- Viajantes: {$adults} adultos, {$children} crianças
- Tem carro: {$hasCar}
- Orçamento: {$budgetName} ({$budgetMin}-{$budgetMax} EUR/dia por pessoa)
- Interesses: {$categories}
{$gemsSection}{$partnersSection}

REGRAS:
- Cada dia deve ter atividade de manhã, tarde e noite
- Usar nomes reais de locais, restaurantes e atrações que existam na ilha {$island}
- Considerar transporte (carro vs transporte público/táxi)
- Adaptar atividades se há crianças presentes
- Manter dentro do orçamento
- Incluir custo estimado por atividade
- Se existem hidden gems/dicas locais acima, incluir pelo menos 1 por dia no itinerário
- Se existem parceiros recomendados, incluí-los nas atividades quando fazem sentido para o dia e orçamento
- Todo o texto em Português (Portugal)

Responde APENAS com JSON válido neste formato exato:
{
  "title": "string - título criativo da viagem",
  "summary": "string - resumo de 2-3 frases da viagem",
  "days": [
    {
      "day": 1,
      "title": "string - título temático do dia",
      "morning": {
        "activity": "string - nome da atividade",
        "description": "string - o que fazer, onde ir",
        "location": "string - nome do local",
        "estimated_cost": "string - ex: 0€, 15€ pp",
        "duration": "string - ex: 2h, 3h",
        "tip": "string - dica útil para esta atividade",
        "is_hidden_gem": false,
        "partner": null
      },
      "afternoon": {
        "activity": "string",
        "description": "string",
        "location": "string",
        "estimated_cost": "string",
        "duration": "string",
        "tip": "string",
        "is_hidden_gem": false,
        "partner": null
      },
      "evening": {
        "activity": "string",
        "description": "string",
        "location": "string",
        "estimated_cost": "string",
        "duration": "string",
        "tip": "string",
        "is_hidden_gem": false,
        "partner": null
      }
    }
  ],
  "tips": ["string - array de dicas gerais da viagem"],
  "estimated_total_cost": "string - custo total estimado para todos os viajantes",
  "partners_included": [
    {
      "name": "string - nome do parceiro",
      "price": "string - preço",
      "contact": "string - contacto",
      "link": "string ou null"
    }
  ]
}

NOTAS sobre o JSON:
- "is_hidden_gem": true quando a atividade é uma dica local/hidden gem
- "partner": quando a atividade é de um parceiro, preencher com {"name": "...", "contact": "...", "price": "..."}; caso contrário null
- "partners_included": lista de todos os parceiros usados no itinerário
PROMPT;

        return $prompt;
    }
}
