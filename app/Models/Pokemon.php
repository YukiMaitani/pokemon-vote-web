<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pokemon extends Model
{
    use HasFactory;
    //protected $fillable = ['pokeId', 'pokeDexNum', 'name', 'type1', 'type2', 'form', 'imageUrl'];
    protected $table = 'pokemons';
}
