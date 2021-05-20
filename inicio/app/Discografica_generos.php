<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Discografica_generos extends Model
{
    protected $table = "discografica_generos";

    protected $fillable = [
        'disco_genero'
    ];
}
