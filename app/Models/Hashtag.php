<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class Hashtag extends Model
{
    use HasFactory;

    protected $guarded = [];
    public $timestamps = false;

    public function posts() {
        return $this->belongsToMany(Post::class);
    }

}
