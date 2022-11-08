<?php

namespace App\Http\Controllers;

use App\Models\Pokemon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ViewOnlyDatabaseController extends Controller
{
    function pokemons() {
        $pokemons = DB::table('pokemons')->paginate(50);
        return view('database_pokemons', ['pokemons' => $pokemons]);
    }
}
