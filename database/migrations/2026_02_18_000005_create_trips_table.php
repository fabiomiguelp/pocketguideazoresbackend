<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('trips', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('island_id')->constrained()->onDelete('cascade');
            $table->foreignId('budget_level_id')->constrained()->onDelete('cascade');
            $table->foreignId('city_id')->constrained()->onDelete('cascade');
            $table->integer('num_travelers');
            $table->integer('duration_days');
            $table->boolean('has_car')->default(false);
            $table->timestamps();

            $table->index('user_id');
            $table->index('island_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trips');
    }
};
