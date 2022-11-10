<?php

namespace App\Http\Controllers;

use App\Enums\PokemonType;
use App\Models\Pokemon;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class InputPokemonDataController extends Controller
{

    function show(Request $request)
    {
        $pokeId = $request->input('pokeId');
        $data = null;
        if(isset($pokeId)) {
            $data = $this->getData($pokeId);
            $this->savePokemonData($data);
        }
        return view('input_pokemon_data', ['data'=> $data, 'searchValue' => $pokeId]);
    }

    //https://qiita.com/Amy2020sg/items/17987f4f7ee867285064 参考
    function saveImage($imageUrl, $name) {
        $img_downloaded = file_get_contents($imageUrl);
        $tmp = tmpfile();
        fwrite($tmp, $img_downloaded);
        $tmp_path = stream_get_meta_data($tmp)['uri'];
        Storage::putFileAs('public/images/pokemons', new File($tmp_path), $name.'.png');
        fclose($tmp);
    }

    function savePokemonData($dataArray) {
        foreach($dataArray as $data) {
            $pokemon = new Pokemon;
            $pokemon->pokemons_id = $data['pokeId'];
            $pokemon->pokemons_pokedex_num = $data['pokeDexNum'];
            $pokemon->pokemons_name = $data['name'];
            $pokemon->pokemons_type1 = $data['type1'];
            $pokemon->pokemons_type2 = $data['type2'];
            $pokemon->pokemons_form = $data['form'];
            if(isset($data['imageUrl'])) { $this->saveImage($data['imageUrl'], $data['pokeId']); }
            $pokemon->save();
        }
    }

    function getData($pokeDexNum)
    {
        $uri = 'https://pokeapi.co/api/v2/pokemon-species/'.$pokeDexNum;
        $json = $this->getJson($uri);
        $data = null;
        if(isset($json)) {
            $data = [];
            $varietiesCount = count($json['varieties']);
            $name = $json['names'][0]['name'];
            $element = ['pokeDexNum'=>$pokeDexNum,'name'=>$name];

            $foundationUri = 'https://pokeapi.co/api/v2/pokemon/'.$pokeDexNum;
            $foundationJson = $this->getJson($foundationUri);

            $defaultPokeId = $pokeDexNum * 10;
            $defaultElement['pokeId'] = $defaultPokeId;
            $defaultElement['imageUrl'] = $foundationJson['sprites']['front_default'];
            $defaultElement['form'] = null;
            $defaultTypes = $this->getTypes($foundationJson['types']);
            $defaultElement['type1'] = $defaultTypes[0];
            $defaultElement['type2'] = count($defaultTypes) === 2 ? $defaultTypes[1] : null;
            array_push($data, $element + $defaultElement);

            //別の姿がなければデフォルトのみなので返す
            if ($varietiesCount === 1) { return $data; }

            //ピカチュウはヤバいので返す
            if ($name === 'ピカチュウ') { return $data; }

            //デフォルトデータが配列の最初に入っているから２番目から。以下の処理は全て別の姿を扱ったもの
            for($num=1;$num<$varietiesCount;++$num) {
                $varietiesName = $json['varieties'][$num]['pokemon']['name'];

                //メガ進化、ダイマックス、ヌシポケモン、ゲンシカイキ、レッツゴーは抜き。出現数が多い順に条件設定。
                if(strpos($varietiesName, 'mega') || str_ends_with($varietiesName, 'max') || strpos($varietiesName, 'totem') || str_ends_with($varietiesName, 'primal') || str_ends_with($varietiesName, 'starter'))  { continue; }
                $anotherData['pokeId'] = $defaultPokeId + $num;
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
            $typeJp = PokemonType::from($typeEn)->label();
            array_push($typeTranslatedArray, $typeJp);
        }
        return $typeTranslatedArray;
    }
}
