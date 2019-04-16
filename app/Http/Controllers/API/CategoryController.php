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
}
