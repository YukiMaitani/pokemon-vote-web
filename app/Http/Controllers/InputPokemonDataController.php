<?php

namespace App\Http\Controllers;

use App\Enums\PokemonStat;
use App\Enums\PokemonType;
use App\Models\Pokemon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

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
            $pokemon->pokemons_base_stats = $data['base_stats'];
            $pokemon->pokemons_is_default = $data['isDefault'];
            $pokemon->pokemons_is_sv = $data['isSV'];
            if(isset($data['imageUrl']) && !File::exists(storage_path('app/public/images/pokemons/'.$data['pokeId'].'.png'))) { $this->saveImage($data['imageUrl'], $data['pokeId']); }
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
            $varieties =$json['varieties'];
            $varietiesCount = count($varieties);
            $name = $json['names'][0]['name'];
            $element = ['pokeDexNum'=>$pokeDexNum,'name'=>$name, 'isSV'=>false];

            $foundationUri = 'https://pokeapi.co/api/v2/pokemon/'.$pokeDexNum;
            $foundationJson = $this->getJson($foundationUri);

            $defaultPokeId = $pokeDexNum * 10;
            $defaultElement['pokeId'] = $defaultPokeId;
            $defaultElement['imageUrl'] = $foundationJson['sprites']['front_default'];
            $defaultElement['isDefault'] = true;
            $defaultElement['form'] = $this->getForm($foundationJson['forms'][0]['url']);
            $defaultTypes = $this->getTypes($foundationJson['types']);
            $defaultElement['type1'] = $defaultTypes[0];
            $defaultElement['type2'] = count($defaultTypes) === 2 ? $defaultTypes[1] : null;
            $defaultElement['base_stats'] = $this->getStats($foundationJson['stats']);

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
                $anotherData['isDefault'] = false;
                $anotherUri = $varieties[$num]['pokemon']['url'];
                $anotherJson = $this->getJson($anotherUri);
                $anotherTypes = $this->getTypes($anotherJson['types']);
                $anotherData['type1'] = $anotherTypes[0];
                $anotherData['type2'] = count($anotherTypes) === 2 ? $anotherTypes[1] : null;
                $anotherData['imageUrl'] = $anotherJson['sprites']['front_default'];
                $anotherData['form'] = $this->getForm($anotherJson['forms'][0]['url']);
                $anotherData['base_stats'] = $this->getStats($foundationJson['stats']);
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

    function getTypes($typeArray): array
    {
        $typeNum = count($typeArray);
        $typeTranslatedArray = [];
        for ($num=0;$num<$typeNum;++$num) {
            $typeEn = $typeArray[$num]['type']['name'];
            $typeJp = PokemonType::find($typeEn)->label();
            array_push($typeTranslatedArray, $typeJp);
        }
        return $typeTranslatedArray;
    }

    function getStats($statArray)
    {
        $statTranslatedArray = [];
        foreach ($statArray as $stat) {
            $baseStat = $stat['base_stat'];
            $statEn = $stat['stat']['name'];
            $statJp = PokemonStat::from($statEn)->label();
            array_push($statTranslatedArray,[$statJp => $baseStat]);
        }
        return json_encode($statTranslatedArray, JSON_UNESCAPED_UNICODE);
    }

    function getForm($formUri)
    {
        $formJson = $this->getJson($formUri);
        $formArray = $formJson['form_names'];
        if (count($formArray) === 0) { return null; }
        $form = $formArray[0]['name'];
        return $this->parseForm($form);
    }

    function parseForm($form)
    {
        return match ($form){
            'Hisuian Form' => 'ヒスイのすがた',
            'Origin Forme' => 'オリジンフォルム',
            'White-Striped Form' => 'しろすじ',
            'Male' => 'オスのすがた',
            'Female' => 'メスのすがた',
            'Incarnate Forme' => 'けしんフォルム',
            'Therian Forme' => 'れいじゅうフォルム',
            default => $form
        };
    }

    //一回でDBの全てのデータを取る。もう少し整形必要。allではなくwhereでデータを抽出して実験。
    function saveJsonFile()
    {
        $pokemons = Pokemon::all();
        $json = json_encode($pokemons, JSON_UNESCAPED_UNICODE);
        file_put_contents('pokemons.json',$json);
    }
}
