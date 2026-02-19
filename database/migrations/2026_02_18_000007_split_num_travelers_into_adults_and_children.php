<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('trips', function (Blueprint $table) {
            $table->integer('num_adults')->default(1)->after('city_id');
            $table->integer('num_children')->default(0)->after('num_adults');
            $table->dropColumn('num_travelers');
        });
    }

    public function down(): void
    {
        Schema::table('trips', function (Blueprint $table) {
            $table->integer('num_travelers')->after('city_id');
            $table->dropColumn(['num_adults', 'num_children']);
        });
    }
};
