<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;
    protected $fillable = 
    [
        'imageName' ,
        'image',
        'album_id',
        'user_id'
    ];

    public function album()
    {
        return $this->belongsTo(Album::class);
    }
}
