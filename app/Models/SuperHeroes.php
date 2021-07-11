<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuperHeroes extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table = 'superheroes';

    protected $fillable = [
        'nickname',
        'real_name',
        'origin_description',
        'superpowers',
        'catch_phrase',
        'path_to_image'
    ];



}
