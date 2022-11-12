<?php

namespace App\Enums;

//https://blog.capilano-fw.com/?p=9829 参考
//https://www.pnkts.net/2022/01/14/laravel-validation-rule-enum
enum PokemonType: int
{
    // 基本情報
    case normal = 1;
    case fire = 2;
    case water = 3;
    case grass = 4;
    case electric = 5;
    case ice = 6;
    case fighting = 7;
    case poison = 8;
    case ground = 9;
    case flying = 10;
    case psychic = 11;
    case bug = 12;
    case rock = 13;
    case ghost = 14;
    case dragon = 15;
    case dark = 16;
    case steel = 17;
    case fairy = 18;

    // 日本語を追加
    public function label(): string
    {
        return match($this)
        {
            PokemonType::normal => 'ノーマル',
            PokemonType::fire => 'ほのお',
            PokemonType::water => 'みず',
            PokemonType::grass => 'くさ',
            PokemonType::electric => 'でんき',
            PokemonType::ice => 'こおり',
            PokemonType::fighting => 'かくとう',
            PokemonType::poison => 'どく',
            PokemonType::ground => 'じめん',
            PokemonType::flying => 'ひこう',
            PokemonType::psychic => 'エスパー',
            PokemonType::bug => 'むし',
            PokemonType::rock => 'いわ',
            PokemonType::ghost => 'ゴースト',
            PokemonType::dragon => 'ドラゴン',
            PokemonType::dark => 'あく',
            PokemonType::steel => 'はがね',
            PokemonType::fairy => 'フェアリー',
        };
    }

    public static function labelArray(): array
    {
        return [
            'ノーマル',
            'ほのお',
            'みず',
            'くさ',
            'でんき',
            'こおり',
            'かくとう',
            'どく',
            'じめん',
            'ひこう',
            'エスパー',
            'むし',
            'いわ',
            'ゴースト',
            'ドラゴン',
            'あく',
            'はがね',
            'フェアリー',
        ];
    }
}
