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
        Schema::create('pokemons', function (Blueprint $table) {
            $table->unsignedBigInteger('pokemons_id')->primary();
            $table->integer('pokemons_pokedex_num');
            $table->string('pokemons_name');
            $table->string('pokemons_type1');
            $table->string('pokemons_type2')->nullable();
            $table->string('pokemons_form')->nullable();
            $table->json('pokemons_base_stats');
            $table->boolean('pokemons_is_default');
            $table->boolean('pokemons_is_sv');
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
        Schema::dropIfExists('pokemons');
    }
};
