<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('partners', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->foreignId('island_id')->constrained()->cascadeOnDelete();
            $table->foreignId('budget_level_id')->constrained()->cascadeOnDelete();
            $table->foreignId('trip_category_id')->constrained()->cascadeOnDelete();
            $table->decimal('price', 8, 2);
            $table->string('contact');
            $table->string('link')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('partners');
    }
};
