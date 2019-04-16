<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;
    //createdPost
    protected $fillable = ['title', 'body', 'author_id',];

    public function users() {
      return $this->belongsTo('App\User');
    }

    public function categories() {
      return $this->belongsToMany('App\Category', 'posts_categories');
    }
}
