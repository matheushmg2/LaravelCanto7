<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{

    protected $table = "agendas";

    protected $fillable = [
        'user_id', 'data', 'hora', 'estado', 'cidade', 'cep', 'rua', 'bairro', 'ibge'
    ];

    protected $hidden = ['created_at', 'updated_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
