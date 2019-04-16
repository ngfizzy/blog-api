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
    $postCategory = [
      'postId' => $postId,
      'categoryId' => $categoryId,
    ];

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
      'postCategory' => $postCategory,
    ]);
  }
}
