<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ImagensGalerias extends Model
{
    protected $fillable = [
        'user_id', 'discografia_id'
    ];

    protected $hidden = ['created_at', 'updated_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function image()
    {
        return $this->morphMany('App\Galeria', 'imageble');
    }

    public function discografia()
    {
        return $this->belongsTo(Discografia::class); // Muitos
    }
}
