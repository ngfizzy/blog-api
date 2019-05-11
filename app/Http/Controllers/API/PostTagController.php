<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

    /**
     * Remove  Tag From a post
     *
     * @param int $postId
     * @param int $tagId
     *
     * @return \Illuminate\Http\Response Response
     */
    function remove($postId, $tagId) {
      $response = [
        'error' => true,
        'message' => 'Something went wrong',
        'postTag' => [
          'postId' => $postId,
          'tagId' => $tagId,
        ],
      ];

      $postTag = DB::table('posts_tags')->where('post_id', $postId)
        ->where('tag_id', $tagId)
        ->first();

      if (!$postTag) {
        $response['message'] = 'No matching record to remove';

        return response()->json($response, 404);
      }

      $post = $this->post->find($postId);
      $post->tags()->detach($tagId);

      $response['error'] = false;
      $response['message'] = 'Tag removed successfully';
      $response['tags'] = $post->tags;

      return response()->json($response);
    }

    function viewTagPosts($tagId) {
      $tagPosts = $this->tag->with('posts')->find($tagId);
      $tagPosts = $tagPosts ? $tagPosts : [];

      $message = sizeof($tagPosts['posts']) ? 'Found some related posts' : 'Did not find a related post';

      return response()->json([
        'error' => false,
        'message' => $message,
        'tagPosts' => $tagPosts,
      ]);
    }
}
