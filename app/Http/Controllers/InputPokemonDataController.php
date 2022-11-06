<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

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
            $defaultTypes = $this->getTypes($foundationJson['types']);
            $defaultElement['type1'] = $defaultTypes[0];
            $defaultElement['type2'] = count($defaultTypes) === 2 ? $defaultTypes[1] : null;
            array_push($data, $element + $defaultElement);

            //別の姿がなければデフォルトのみなので返す
            if ($varietiesCount === 1) { return $data; }

            //デフォルトデータが配列の最初に入っているから２番目から。以下の処理は全て別の姿を扱ったもの
            for($num=1;$num<$varietiesCount;++$num) {
                $varietiesName = $json['varieties'][$num]['pokemon']['name'];

                //メガ進化とダイマックスは抜き。ゲンシカイキが含まれるが、速度優先で後から手動で削除
                if(strpos($varietiesName, 'mega') || str_ends_with($varietiesName, 'gmax')) { continue; }
                $anotherUri = $json['varieties'][$num]['pokemon']['url'];
                $anotherJson = $this->getJson($anotherUri);
                $anotherTypes = $this->getTypes($anotherJson['types']);
                $anotherData['type1'] = $anotherTypes[0];
                $anotherData['type2'] = count($anotherTypes) === 2 ? $anotherTypes[1] : null;
                $anotherFormUri = $anotherJson['forms'][0]['url'];
                $anotherFormJson = $this->getJson($anotherFormUri);
                $anotherData['form'] = $anotherFormJson['form_names'][0]['name'];
                $anotherData['imageUrl'] = $anotherFormJson['sprites']['front_default'];
                array_push($data, $element + $anotherData);
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
                return 'エスパー';
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
