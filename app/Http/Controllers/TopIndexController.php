<?php

namespace App\Http\Controllers;

use App\Models\Pokemon;
use Illuminate\Http\Request;

class TopIndexController extends Controller
{
    function index(Request $request) {
        $pokemons = $this->search($request);
        return view('top_index')->with('pokemons', $pokemons);
    }

    function search(Request $request) {
        $query = Pokemon::query();
        $keyword = $request->input('keyword');
        $isSV = $request->input('isSV');
        if($isSV) {
            $query = $query->where('pokemons_is_sv',true);
        }
        $pokemons = $query->where('pokemons_name', 'LIKE', "%{$keyword}%")->paginate(30);
        return $pokemons;
    }
}
