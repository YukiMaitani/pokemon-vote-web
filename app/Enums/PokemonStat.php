<?php


namespace App\Enums;

//caseの命名規則でハイフンを入れられないためこのような形。本当はcase special-attack = 'とくこう'のようにしたかった。
//普通に連想配列を定義した方が良さそう
enum PokemonStat: string
{
    case stat1 = 'hp';
    case stat2 = 'attack';
    case stat3 = 'defense';
    case stat4 = 'special-attack';
    case stat5 = 'special-defense';
    case stat6 = 'speed';

    public function label(): string
    {
        return match($this)
        {
            PokemonStat::stat1 => 'HP',
            PokemonStat::stat2 => 'こうげき',
            PokemonStat::stat3 => 'ぼうぎょ',
            PokemonStat::stat4 => 'とくこう',
            PokemonStat::stat5 => 'とくぼう',
            PokemonStat::stat6 => 'すばやさ'
        };
    }
}
