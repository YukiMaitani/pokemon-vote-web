<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InputPokemonDataController extends Controller
{
    function input() {
        return view('input_pokemon_data');
    }
}
