<?php

namespace App\Http\Controllers;

use App\Models\Pokemon;
use App\Models\TerastalVote;
use Illuminate\Http\Request;
use App\Enums\PokemonType;

class PokemonDetailController extends Controller
{
    function show($pokeId) {
        $pokemon = Pokemon::query()->find($pokeId);
        $pokemonTypes = PokemonType::cases();
        return view('pokemon_detail', ['pokemon' => $pokemon, 'pokemonTypes' => $pokemonTypes]);
    }

    function vote(Request $request, $pokeId) {
        $vote = new TerastalVote;
        $vote->pokemon_id = $pokeId;
        $vote->pokemon_type_id = $request->pokemon_type;
        $vote->save();
        return to_route('pokemon.detail.show', ['pokeId' => $pokeId]);
    }
}
