<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;
    protected $fillable = ['title', 'body', 'author_id', 'published'];

    public function users() {
      return $this->belongsTo('App\User');
    }

    public function categories() {
      return $this->belongsToMany('App\Category', 'posts_categories');
    }

    public function tags() {
      return $this->belongsToMany('App\Tag', 'posts_tags');
    }
}
