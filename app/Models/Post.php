<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $connection = 'mongodb';
    protected $guarded = [];
    public $timestamps = true;
    protected $casts = [
        'hashtags' => 'array'
    ];


    public function hashtags()
    {
        return $this->belongsToMany(Hashtag::class);
    }

}
