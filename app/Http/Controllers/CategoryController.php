<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('api');
    }

    /**
     * Return all categories with optionnal option
     */
    public function list(int $excludedId = null): JsonResponse
    {
        $categories = null;

        if (isset($excludedId)) {
            $categories = Category::where('id', '!=', $excludedId)
                ->orderBy('name', 'ASC')
                ->get();
        } else {
            $categories = Category::orderBy('name', 'ASC')->get();
        }

        return response()->json($categories, Response::HTTP_OK);
    }
}
