<?php

namespace App\Http\Controllers;

use App\Models\Pokemon;

class ViewOnlyDBController extends Controller
{
    function pokemons() {
        $pokemons = Pokemon::query()->paginate(50);
        return view('database_pokemons', ['pokemons' => $pokemons]);
    }
}
