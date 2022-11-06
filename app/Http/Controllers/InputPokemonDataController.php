<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class InputPokemonDataController extends Controller
{

    function input(Request $request) {
        $pokeNum = $request->input('pokeNum');
        //$data = null; ここで宣言しなくてもdataを渡せている理由が分からない。viewの第二引数はないと当然渡せない
        if(isset($pokeNum)) {
            $data = $this->getData($pokeNum);
        }
        return view('input_pokemon_data', ['data'=>$data]);
    }

    function getData($pokeNum) {
        $uri = 'https://pokeapi.co/api/v2/pokemon/'.$pokeNum;
        $json = $this->getJson($uri);
        //こっちはinputと違い定義が必要。なんで？
        $name = null;
        if(isset($json)) {
            $speciesUri = $json['species']['url'];
            $speciesJson = $this->getJson($speciesUri);
            $name = $speciesJson['names'][0]['name'];
        }
        return $name;
    }

    function  getJson($uri) {
        $response = Http::get($uri);
        return $response->json();
    }
}
