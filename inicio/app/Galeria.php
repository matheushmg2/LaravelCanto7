<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Galeria extends Model
{
    protected $table = "galerias";

    protected $fillable = [
        'url', 'nome_arquivos', 'tipo'
    ];

    protected $hidden = ['created_at', 'updated_at'];

    public function imageble()
    {
        return $this->morphTo();
    }

}
