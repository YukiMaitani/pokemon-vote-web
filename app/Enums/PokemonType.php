<?php

namespace App\Enums;

//https://blog.capilano-fw.com/?p=9829 参考
//https://www.pnkts.net/2022/01/14/laravel-validation-rule-enum
//https://cpoint-lab.co.jp/article/202206/22902/
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

    public function rgba(): array
    {
        return match ($this)
        {
            PokemonType::normal => ['r'=>168,'g'=>168,'b'=>120,'a'=>1],
            PokemonType::fire => ['r'=>240,'g'=>128,'b'=>48,'a'=>1],
            PokemonType::water => ['r'=>104,'g'=>144,'b'=>240,'a'=>1],
            PokemonType::grass => ['r'=>120,'g'=>200,'b'=>60,'a'=>1],
            PokemonType::electric => ['r'=>248,'g'=>208,'b'=>48,'a'=>1],
            PokemonType::ice => ['r'=>152,'g'=>216,'b'=>216,'a'=>1],
            PokemonType::fighting => ['r'=>192,'g'=>48,'b'=>40,'a'=>1],
            PokemonType::poison => ['r'=>160,'g'=>64,'b'=>160,'a'=>1],
            PokemonType::ground => ['r'=>224,'g'=>192,'b'=>104,'a'=>1],
            PokemonType::flying => ['r'=>168,'g'=>144,'b'=>240,'a'=>1],
            PokemonType::psychic => ['r'=>248,'g'=>88,'b'=>136,'a'=>1],
            PokemonType::bug => ['r'=>168,'g'=>184,'b'=>32,'a'=>1],
            PokemonType::rock => ['r'=>184,'g'=>160,'b'=>56,'a'=>1],
            PokemonType::ghost => ['r'=>112,'g'=>88,'b'=>152,'a'=>1],
            PokemonType::dragon => ['r'=>112,'g'=>56,'b'=>248,'a'=>1],
            PokemonType::dark => ['r'=>112,'g'=>88,'b'=>72,'a'=>1],
            PokemonType::steel => ['r'=>184,'g'=>184,'b'=>208,'a'=>1],
            PokemonType::fairy => ['r'=>238,'g'=>153,'b'=>172,'a'=>1],
        };
    }

    public function colorCode(): string
    {
        return match($this)
        {
            PokemonType::normal => 'A8A878',
            PokemonType::fire => 'F08030',
            PokemonType::water => '6890F0',
            PokemonType::grass => '78C850',
            PokemonType::electric => 'F8D030',
            PokemonType::ice => '98D8D8',
            PokemonType::fighting => 'C03028',
            PokemonType::poison => 'A040A0',
            PokemonType::ground => 'E0C068',
            PokemonType::flying => 'A890F0',
            PokemonType::psychic => 'F85888',
            PokemonType::bug => 'A8B820',
            PokemonType::rock => 'B8A038',
            PokemonType::ghost => '705898',
            PokemonType::dragon => '7038F8',
            PokemonType::dark => '705848',
            PokemonType::steel => 'B8B8D0',
            PokemonType::fairy => 'EE99AC',
        };
    }

    public static function find(string $key): PokemonType
    {
        return match ($key)
        {
            'normal' => PokemonType::normal,
            'fire' => PokemonType::fire,
            'water' => PokemonType::water,
            'grass' => PokemonType::grass,
            'electric' => PokemonType::electric,
            'ice' => PokemonType::ice,
            'fighting' => PokemonType::fighting,
            'poison' => PokemonType::poison,
            'ground' => PokemonType::ground,
            'flying' => PokemonType::flying,
            'psychic' => PokemonType::psychic,
            'bug' => PokemonType::bug,
            'rock' => PokemonType::rock,
            'ghost' => PokemonType::ghost,
            'dragon' => PokemonType::dragon,
            'dark' => PokemonType::dark,
            'steel' => PokemonType::steel,
            'fairy' => PokemonType::fairy
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

    public static function casesArray(): array
    {
        return [
            PokemonType::normal,
            PokemonType::fire,
            PokemonType::water,
            PokemonType::grass,
            PokemonType::electric,
            PokemonType::ice,
            PokemonType::fighting,
            PokemonType::poison,
            PokemonType::ground,
            PokemonType::flying,
            PokemonType::psychic,
            PokemonType::bug,
            PokemonType::rock,
            PokemonType::ghost,
            PokemonType::dragon,
            PokemonType::dark,
            PokemonType::steel,
            PokemonType::fairy,
        ];
    }
}
