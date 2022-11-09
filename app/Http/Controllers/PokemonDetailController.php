<?php

namespace App\Http\Controllers;

use App\Models\Pokemon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Enums\PokemonType;

class PokemonDetailController extends Controller
{
    function show($pokeId) {
        $pokemon = DB::table('pokemons')->where('pokemons_id', $pokeId)->get()->first();
        $pokemonTypes = PokemonType::cases();
        return view('pokemon_detail', ['pokemon' => $pokemon, 'pokemonTypes' => $pokemonTypes]);
    }
}
