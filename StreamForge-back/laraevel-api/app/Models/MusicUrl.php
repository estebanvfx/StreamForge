<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MusicUrl extends Model
{
    use HasFactory;

    protected $table = 'music_urls';

    protected $fillable = [
        'url',
        'url_type'
    ];
}
