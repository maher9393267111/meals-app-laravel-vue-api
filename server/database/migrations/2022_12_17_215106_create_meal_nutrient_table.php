<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meal_nutrient', function (Blueprint $table) {
            $table->id();
            $table->foreignId('meal_id')->constrained();
            $table->foreignId('nutrient_id')->constrained();
            $table->float('standard_amount');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('meal_nutrient');
    }
};
