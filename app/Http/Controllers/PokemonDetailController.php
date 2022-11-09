<?php

namespace App\Http\Controllers;

use App\Models\Pokemon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PokemonDetailController extends Controller
{
    function show($pokeId) {
        $pokemon = DB::table('pokemons')->where('pokemons_pokeId', $pokeId)->get()->first();
        return view('pokemon_detail', ['pokemon' => $pokemon]);
    }
}
