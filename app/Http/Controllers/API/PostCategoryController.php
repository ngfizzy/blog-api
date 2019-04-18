<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Post;
use App\Category;

class PostCategoryController extends Controller
{
  protected $post, $category;

  function __construct(Post $post, Category $category) {
      $this->post = $post;
      $this->category = $category;
  }

  /**
   * Add a post to a category
   * 
   * @param \Illuminate\Http\Request $request
   *
   * @return \Illuminate\Http\Response
   */
  function create(Request $request) {
    $request->validate([
      'postId' => 'required|exists:posts,id',
      'categoryId' => 'required|exists:categories,id',
    ]);


    $postId = $request->get('postId');
    $categoryId = $request->get('categoryId');

    $postCategory = DB::table('posts_categories')
      ->where('post_id', $postId)
      ->where('category_id', $categoryId)
      ->first();
    
    if ($postCategory) {
      return response()->json([
        'error' => true,
        'message' => 'Post already added to category',
        'postCategory' => $postCategory,
      ], 409);
    }

    $post = $this->post->find($postId);
    $post->categories()->attach($categoryId);

    return response()->json([
      'error' => false,
      'message' => 'Post added to category successfully',
      'postCategory' =>  [
        'postId' => $postId,
        'categoryId' => $categoryId,
      ],
    ]);
  }

  /**
   * Remove post from category
   *
   * @param int $postId
   * @param int $categoryId
   *
   * @return \Illumate\Http\Response
   */
  function remove($postId, $categoryId) {
    $postCategory = DB::table('posts_categories')
    ->where('post_id', $postId)
    ->where('category_id', $categoryId)
    ->first();

    if (!$postCategory) {

      return response()->json([
        'error' => true,
        'message' => 'Post is not in specified category',
        'postCategory' => $postCategory,
      ]);
    }

    $this->post->find($postId)
      ->categories()
      ->detach($categoryId);

    return response()->json([
      'error' => false,
      'message' => 'post removed from category',
      'postCategory' => $postCategory,
    ]);
  }

  /**
   * Get post belonging to a category
   *
   * @param int $categoryId 
   *
   * @return \Illuminate\Http\Request
   */
  function viewCategoryPosts($categoryId) {
    $categoryPosts = $this->category->with('posts')->find($categoryId);
    $categoryPosts = $categoryPosts ? $categoryPosts : [];

    $message = !empty($categoryPosts) && sizeof($categoryPosts['posts']) ?
      'Found some related posts' : 'Did not find a related post';

    return response()->json([
      'error' => false,
      'message' => $message,
      'tagPosts' => $categoryPosts,
    ]);
  }
}
