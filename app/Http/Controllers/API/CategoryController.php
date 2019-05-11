<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Category;

class CategoryController extends Controller
{
  private $category;

  function __construct(Category $category) {
    $this->category = $category;
  }

  /**
   * Get all categories
   *
   * @return \Illuminate\Http\Response
   */
  function index() {
     $categories = $this->category->all();

     return response()->json([
       'error' => false,
       'message' => 'All created categories',
       'categories' => $categories,
     ]);
  }

  /**
   * Get category by Id
   *
   * @param int $id Category Id
   *
   * @return \Illumintate\Http\Request
   */
  function view($id) {

    $category = $this->category->find($id);

    if ($category) {
      return response()->json([
        'error' => false,
        'message' => 'Found category',
        'category' => $category,
      ]);
    }

    return response()->json([
      'error' => true,
      'message' => 'Category not found',
      'categoryId' => $id
    ], 404);
  }

  /**
   * Create a category
   *
   * @param \Illuminate\Http\Request $request
   *
   * @return \Illuminate\Http\Response
   */
  function create(Request $request) {
    $request->validate([
      'name' => 'required|max:50|unique:categories'
    ]);

    $category = $this->category->create(['name' => $request->get('name')]);

    return response()->json([
      'error' => false,
      'message' => 'Category created successfully',
      'category' => $category
    ], 201);
  }

  /**
   * Update Category
   * 
   * @param \Illuminate\Http\Request
   * @param int $id
   * 
   * @return \Illuminate\Http\Response
   */
  function update(Request $request, $id) {
    $request->validate([
      'name' => 'required|max:50|unique:categories'
    ]);

    $category = $this->category->find($id);

    if ($category) {
      $category['name'] = $request->get('name');
      
      $category->save();

      return response()->json([
        'error' => false,
        'message' => 'Category name updated',
        'category' => $category,
      ]);
    }

    return response()->json([
      'error' => true,
      'message' => 'Could not find category',
      'category' => [
        'name' => $request->get('name'),
        'id' => $id,
      ],
    ]);
  }
}
