<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Post;

class PostController extends Controller
{
    
    /**
     * Create a Post
     *
     * @param  \Illuminate\Http\Request  $request
     * 
     * @return \Illuminate\Http\Response
     **/
    function create(Request $request) {
      $request->validate([
        'title' => 'required|max:250',
        'body' =>  'required',
      ]);

      $post = $request->only('title', 'body');
      $post['author_id'] = auth()->user()->id;

      $createdPost = Post::create($post);

      if ($createdPost) {
       return response()->json([
         'error' => false,
         'message' => 'Post created successfully',
         'post' => $post,
       ], 201);
      }

      return response()->json([
        'error' => true,
        'message' => 'Could not create post. Make sure your request is correctly formed',
        'post' => null,
      ], 422);
    }
}
