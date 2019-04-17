<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Tag;
use App\Post;

class PostTagController extends Controller
{
    protected $post;
    protected $tag;

    function __construct(Post $post, Tag $tag) {
      $this->post = $post;
      $this->tag = $tag;
    }

    /**
     * Add a tag to a note
     *
     * @param \ILluminate\Http\Request
     * 
     * @return \Illuminate\Http\Response JSON response of note tags
     */
    function create(Request $request) {
      $request->validate([
        'postId' => 'required|exists:posts,id',
        'tagName' => 'required|min:2|max:50',
      ]);

      $response = [
        'error' => true,
        'message' => 'Something went wrong.'
      ];

      $postId = $request->get('postId');
      $tagName = trim($request->get('tagName'));

      $tag = $this->tag->where('name', $tagName)->first();
      $post = $this->post->find($postId);

      if ($tag) {
        $taggedPost = $tag->posts()->where('post_id', $postId)
          ->where('tag_id', $tag['id']);
  
        if ($taggedPost) {
          $taggedPost = $post->tags;
          $response['error'] = false;
          $response['message'] = 'Tag already exist on data';
          $response['taggedPost'] = $taggedPost;
        
          return response()->json($response);
        }

        $taggedPost = $post->tags()->attach($tagId);

        $response['error'] = false;
        $response['message'] = 'Tag added to note successfully';
        $response['taggedPost'] = $taggedPost;

        return response()->json($response, 201);
      }

      $tag = new Tag();
      $tag['name'] = $tagName;

      $tag->save();
      $post->tags()->attach($tag['id']);

      $response['error'] = false;
      $response['message'] = 'Tag created and added to note successfully';
      $response['taggedPost'] = $post->tags;

      return response()->json($response, 201);
    }
}
