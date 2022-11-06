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
            $varietiesCount = count($json['varieties']);
            $name = $json['names'][0]['name'];
            $pokeDexNum = $json['pokedex_numbers'][0]['entry_number'];
            $element = ['pokeDexNum'=>$pokeDexNum,'name'=>$name];

            $foundationUri = 'https://pokeapi.co/api/v2/pokemon/'.$pokeId;
            $foundationJson = $this->getJson($foundationUri);

            $defaultElement['imageUrl'] = $foundationJson['sprites']['front_default'];
            $defaultElement['form'] = null;
            $defaultElement['types'] = $this->getTypes($foundationJson['types']);
            array_push($data, $element + $defaultElement);
            if ($varietiesCount === 1) { return $data; }

            for($num=1;$num<$varietiesCount;++$num) {
                $varietiesName = $json['varieties'][$num]['pokemon']['name'];
                if(str_ends_with($varietiesName, 'mega') || str_ends_with($varietiesName, 'gmax')) { continue; }

                $varietiesUri = $json['varieties'][$num]['pokemon']['url'];
                $isDefault = $json['varieties'][$num]['is_default'];
                if($isDefault) {
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
