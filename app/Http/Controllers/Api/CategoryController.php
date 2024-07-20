<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use Illuminate\Http\Response;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\CategoryResource;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with(['media'])->get();
        if ($categories) {
            return ResponseHelper::finalResponse(
                'data fetched successfully',
                CategoryResource::collection($categories),
                true,
                Response::HTTP_OK
            );
        }
        return ResponseHelper::finalResponse(
            'data not found',
            null,
            true,
            Response::HTTP_OK
        );
    }
    public function show($id)
    {
        $category = Category::with(
            [
                'media',
                'products' => function ($query) {
                    $query->with([
                        'media',
                        'sideEffects',
                        'indications',
                        'offers'
                    ]);
                }
            ]
        )->find($id);
        if ($category) {
            return ResponseHelper::finalResponse(
                'data fetched successfully',
                CategoryResource::make($category),
                true,
                Response::HTTP_OK
            );
        }
        return ResponseHelper::finalResponse(
            'data not found',
            null,
            true,
            Response::HTTP_OK
        );
    }
}
