<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Discografia extends Model
{
    protected $table = "discografias";

    protected $fillable = [
        'user_id', 'discografica_genero_id', 'nome_album', 'album'
    ];

    protected $hidden = ['created_at', 'updated_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
