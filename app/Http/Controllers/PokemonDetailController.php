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
        $voteCounts = $this->getVoteCounts($pokeId);
        $pokemonTypes = PokemonType::cases();
        return view('pokemon_detail', compact('pokemon','pokemonTypes','voteCounts'));
    }

    function vote(Request $request, $pokeId) {
        $vote = new TerastalVote;
        $vote->pokemon_id = $pokeId;
        $vote->pokemon_type_id = $request->pokemon_type;
        $vote->save();
        return to_route('pokemon.detail.show', ['pokeId' => $pokeId]);
    }

    function getVoteCounts($pokeId) {
        $votes = TerastalVote::query()->where('pokemon_id',$pokeId)->get();
        $voteCountsValue = [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0];
        $voteCountsKey = PokemonType::labelArray();
        $voteCounts = array_combine($voteCountsKey,$voteCountsValue);
        foreach ($votes as $vote) {
            $type = PokemonType::tryFrom($vote->pokemon_type_id)->label();
            $voteCounts[$type] += 1;
        }
        arsort($voteCounts);
        return $voteCounts;
    }
}
