<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GetCategoryController extends Controller
{
    public function __invoke(): JsonResponse
    {
        $categories_subcategories = Category::with('subCategories')->get();
        return response()->json($categories_subcategories);
    }
}
