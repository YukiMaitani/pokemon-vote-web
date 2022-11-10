<?php

namespace App\Http\Controllers;

use App\Models\Pokemon;

class TopIndexController extends Controller
{
    function index() {
        $pokemons = Pokemon::query()->paginate(30);
        return view('top_index')->with('pokemons', $pokemons);
    }
}
