<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
  protected $fillables = [ 'name' ];

  public function posts() {
    return $this->belongsToMany('App\Post', 'posts_categories');
  }
}
