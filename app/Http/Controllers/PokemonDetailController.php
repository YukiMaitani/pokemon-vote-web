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
        $yakkunUrl = $this->yakkun($pokemon);
        return view('pokemon_detail', compact('pokemon','pokemonTypes','voteCounts','yakkunUrl'));
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
        if (count($votes) === 0) { return null;}
        $voteCountsValue = [];
        for($n=1;$n<19;$n++){
            $rgba = PokemonType::from($n)->rgba();
            $rbaString = 'rgba('.$rgba['r'].','.$rgba['g'].','.$rgba['b'].','.$rgba['a'].')';
            array_push($voteCountsValue,[
                'count'=>0,
                'rgba'=>$rbaString
            ]);
        }
        $voteCountsKey = PokemonType::labelArray();
        $voteCounts = array_combine($voteCountsKey,$voteCountsValue);
        foreach ($votes as $vote) {
            $type = PokemonType::from($vote->pokemon_type_id)->label();
            $voteCounts[$type]['count'] += 1;
        }
        arsort($voteCounts);
        return $voteCounts;
    }

    public function yakkun($pokemon) {
        $form = $pokemon->pokemons_form;
        $pokedex_num = $pokemon->pokemons_pokedex_num;

        //アルセウス以降に新たにでたポケモンに対応。swshにアクセスするとエラーになる。
        if($pokedex_num>=899){ return 'https://yakkun.com/legends_arceus/zukan/n'.$pokedex_num; }
        $url = 'https://yakkun.com/swsh/zukan/n'.$pokedex_num;
        if(!isset($form)) { return $url; }

        //対応できてないものは通常フォームを返す。
        return match ($form) {
            'ガラルのすがた' => $url.'g',
            'アローラのすがた' => $url.'a',
            'けんのおう' => $url.'f',
            default => $url
        };
    }
}
