<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //createdPost
    protected $fillable = ['title', 'body', 'author_id',];

    public function users() {
      return $this->belongsTo('App\User');
    }

    public function categories() {
      return $this->belongsToMany('App\Categories', 'posts_categories');
    }
}
