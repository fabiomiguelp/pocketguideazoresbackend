<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Seeder;

class CityGemSeeder extends Seeder
{
    public function run(): void
    {
        $gems = [
            // São Miguel
            'Ponta Delgada' => [
                ['name' => 'Jardim José do Canto', 'description' => 'Jardim botânico escondido junto à Lagoa das Furnas com espécies raras do século XIX.', 'tip' => 'Visitar de manhã cedo para evitar grupos turísticos.'],
                ['name' => 'Mercado da Graça', 'description' => 'Mercado local com produtos regionais, queijos e fruta tropical dos Açores.', 'tip' => 'Provar o ananás dos Açores e o queijo São Jorge.'],
            ],
            'Ribeira Grande' => [
                ['name' => 'Praia de Santa Bárbara ao pôr do sol', 'description' => 'A maior praia de areia dos Açores com vistas espetaculares ao fim do dia.', 'tip' => 'Levar agasalho, o vento pode ser forte ao entardecer.'],
                ['name' => 'Fábrica de Chá Gorreana', 'description' => 'A única plantação de chá da Europa, com visitas guiadas gratuitas e degustação.', 'tip' => 'Comprar o chá verde biológico diretamente na fábrica.'],
            ],
            'Lagoa' => [
                ['name' => 'Miradouro do Cerrado das Freiras', 'description' => 'Miradouro pouco conhecido com vista panorâmica sobre a Lagoa das Sete Cidades.', 'tip' => 'Chegar antes das 9h para ver a neblina a dissipar-se.'],
            ],
            'Vila Franca do Campo' => [
                ['name' => 'Ilhéu de Vila Franca', 'description' => 'Piscina natural vulcânica no meio do mar, reserva natural protegida.', 'tip' => 'Reservar lugar online pois a entrada diária é limitada a 400 pessoas.'],
            ],
            'Nordeste' => [
                ['name' => 'Salto do Prego', 'description' => 'Cascata escondida na floresta laurissilva, acessível por trilho de 40 minutos.', 'tip' => 'Usar calçado impermeável, o trilho pode ser escorregadio.'],
            ],
            'Furnas' => [
                ['name' => 'Poça da Dona Beija', 'description' => 'Piscinas termais naturais com águas ferruginosas rodeadas de vegetação tropical.', 'tip' => 'Ir ao final da tarde quando há menos visitantes.'],
                ['name' => 'Cozido das Furnas', 'description' => 'Prato tradicional cozinhado debaixo da terra pelo calor vulcânico durante 6 horas.', 'tip' => 'Encomendar com antecedência num restaurante local como o Tony.'],
            ],
            // Santa Maria
            'Vila do Porto' => [
                ['name' => 'Baía de São Lourenço', 'description' => 'Baía paradisíaca com vinhas em socalcos e águas cristalinas, pouco frequentada.', 'tip' => 'Descer a pé e levar comida para um piquenique na praia.'],
            ],
            'Santo Espírito' => [
                ['name' => 'Piscinas Naturais de Santo Espírito', 'description' => 'Piscinas de rocha vulcânica com água transparente, ideais para snorkeling.', 'tip' => 'Visitar na maré baixa para melhores condições.'],
            ],
            // Terceira
            'Angra do Heroísmo' => [
                ['name' => 'Grutas do Algar do Carvão', 'description' => 'Chaminé vulcânica com mais de 2000 anos, com estalactites de sílica únicas no mundo.', 'tip' => 'Aberta apenas entre junho e outubro, verificar horários.'],
                ['name' => 'Rua Direita ao anoitecer', 'description' => 'Centro histórico UNESCO com bares e restaurantes típicos açorianos.', 'tip' => 'Experimentar as alcatras no restaurante Beira Mar.'],
            ],
            'Praia da Vitória' => [
                ['name' => 'Baía da Praia da Vitória', 'description' => 'Uma das maiores baías naturais dos Açores com praia de areia dourada.', 'tip' => 'Perfeita para desportos aquáticos nas manhãs calmas.'],
            ],
            'Biscoitos' => [
                ['name' => 'Piscinas Naturais dos Biscoitos', 'description' => 'Piscinas de lava vulcânica com vista para o Pico, rodeadas de vinhas.', 'tip' => 'Combinar com visita ao Museu do Vinho dos Biscoitos.'],
            ],
            // Faial
            'Horta' => [
                ['name' => 'Peter Café Sport', 'description' => 'Bar lendário dos marinheiros transatlânticos com o maior museu de scrimshaw do mundo.', 'tip' => 'Pedir o gin tónico da casa e ver a coleção de bandeiras no teto.'],
                ['name' => 'Marina da Horta - Murais', 'description' => 'Centenas de pinturas deixadas por velejadores de todo o mundo na marina.', 'tip' => 'Reza a tradição que quem não deixar pintura terá azar na viagem.'],
            ],
            // Pico
            'Madalena' => [
                ['name' => 'Vinhas do Pico (UNESCO)', 'description' => 'Paisagem vitícola protegida pela UNESCO com muros de pedra basáltica junto ao mar.', 'tip' => 'Provar o vinho Verdelho do Pico numa adega local.'],
            ],
            'Lajes do Pico' => [
                ['name' => 'Museu dos Baleeiros', 'description' => 'Museu sobre a história da caça à baleia nos Açores em edifício histórico junto ao mar.', 'tip' => 'Combinar com observação de cetáceos no porto de Lajes.'],
            ],
            // São Jorge
            'Velas' => [
                ['name' => 'Fajã dos Cubres', 'description' => 'Fajã costeira acessível por trilho com lagoa e vegetação endémica.', 'tip' => 'Fazer o trilho entre Fajã dos Cubres e Fajã de Santo Cristo.'],
            ],
            'Calheta' => [
                ['name' => 'Fajã de Santo Cristo', 'description' => 'Fajã isolada famosa pelas amêijoas únicas e surf, só acessível a pé.', 'tip' => 'Levar comida e água, não há lojas. O trilho demora cerca de 1h.'],
            ],
            // Graciosa
            'Santa Cruz da Graciosa' => [
                ['name' => 'Furna do Enxofre', 'description' => 'Caverna vulcânica gigante com lago subterrâneo de enxofre no interior.', 'tip' => 'Descer a escadaria em caracol até ao fundo da gruta para a vista completa.'],
            ],
            // Flores
            'Santa Cruz das Flores' => [
                ['name' => 'Cascatas da Ribeira Grande', 'description' => 'Série de cascatas na costa noroeste, visíveis do mar ou de trilhos costeiros.', 'tip' => 'Apanhar um barco para ver as cascatas a cair diretamente no oceano.'],
            ],
            'Fajã Grande' => [
                ['name' => 'Poço do Bacalhau', 'description' => 'Cascata de 90 metros que cai para uma lagoa natural perfeita para banhos.', 'tip' => 'Melhor visitada no verão quando a temperatura da água é mais agradável.'],
            ],
            // Corvo
            'Vila do Corvo' => [
                ['name' => 'Caldeirão do Corvo', 'description' => 'Cratera vulcânica com dois lagos no interior, símbolo da ilha mais pequena dos Açores.', 'tip' => 'Subir de manhã cedo para apanhar céu limpo e vista desimpedida.'],
            ],
        ];

        foreach ($gems as $cityName => $cityGems) {
            $city = City::where('name', $cityName)->first();
            if (!$city) {
                continue;
            }
            foreach ($cityGems as $gem) {
                $city->gems()->create($gem);
            }
        }
    }
}
