<?php

namespace App\Http\Controllers;

use App\Models\Pokemon;
use Illuminate\Http\Request;

class TopIndexController extends Controller
{
    function index(Request $request) {
        $keyword = $request->input('keyword');
        if (isset($keyword)) {
            $pokemons = $this->search($keyword);
            return view('top_index')->with('pokemons', $pokemons);
        }
        $pokemons = Pokemon::query()->paginate(30);
        return view('top_index')->with('pokemons', $pokemons);
    }

    function search($keyword) {
        $query = Pokemon::query();
        $pokemons = $query->where('pokemons_name', 'LIKE', "%{$keyword}%")->paginate(30);
        return $pokemons;
    }
}
