<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use JetBrains\PhpStorm\NoReturn;

class InputPokemonDataController extends Controller
{

    function show(Request $request)
    {
        $pokeId = $request->input('pokeId');
        $data = null;
        if(isset($pokeId)) {
            $data = $this->getData($pokeId);
        }
        return view('input_pokemon_data', ['data'=>$data]);
    }

    function getData($pokeId)
    {
        $uri = 'https://pokeapi.co/api/v2/pokemon-species/'.$pokeId;
        $json = $this->getJson($uri);
        $data = null;
        if(isset($json)) {
            $data = [];
            $name = $json['names'][0]['name'];
            $varietiesCount = count($json['varieties']);
            for($num=0;$num<$varietiesCount;++$num) {
                $element = ['name'=>$name];
                $varietiesName = $json['varieties'][$num]['pokemon']['name'];
                if(str_ends_with($varietiesName, 'mega') || str_ends_with($varietiesName, 'gmax')) { continue; }

                $varietiesUri = $json['varieties'][$num]['pokemon']['url'];
                $isDefault = $json['varieties'][$num]['is_default'];
                if($isDefault) {
                    $foundationJsonData = $this->getJson($varietiesUri);
                    $element['imageUrl'] = $foundationJsonData['sprites']['front_default'];
                    $element['form'] = null;
                    $element['types'] = $this->getTypes($foundationJsonData['types']);
                } else {
                    continue;
                }
                array_push($data, $element);
            }
        }
        return $data;
    }

    function  getJson($uri)
    {
        $response = Http::get($uri);
        return $response->json();
    }

    function getTypes($typeArray)
    {
        $typeNum = count($typeArray);
        $typeTranslatedArray = [];
        for ($num=0;$num<$typeNum;++$num) {
            $typeEn = $typeArray[$num]['type']['name'];
            $typeJp = $this->typeTranslate($typeEn);
            array_push($typeTranslatedArray, $typeJp);
        }
        return $typeTranslatedArray;
    }

    function typeTranslate($typeEn)
    {
        switch ($typeEn) {
            case 'normal':
                return 'ノーマル';
            case 'fire':
                return 'ほのお';
            case 'water':
                return 'みず';
            case 'grass':
                return 'くさ';
            case 'electric':
                return 'でんき';
            case 'ice':
                return 'こおり';
            case 'fighting':
                return 'かくとう';
            case 'poison':
                return 'どく';
            case 'ground':
                return 'じめん';
            case 'flying':
                return 'ひこう';
            case 'psychic':
                return '';
            case 'bug':
                return 'むし';
            case 'rock':
                return 'いわ';
            case 'ghost':
                return 'ゴースト';
            case 'dragon':
                return 'ドラゴン';
            case 'dark':
                return 'あく';
            case 'steel':
                return 'はがね';
            case 'fairy':
                return 'フェアリー';
        }
    }
}
