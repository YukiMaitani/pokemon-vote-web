<?php

namespace App\Http\Controllers;

use App\Models\Pokemon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TopIndexController extends Controller
{
    function index() {
        $pokemons = DB::table('pokemons')->paginate(30);
        return view('top_index')->with('pokemons', $pokemons);
    }
}
