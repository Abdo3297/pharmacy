<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Response;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\ProductResource;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with([
            'media',
            'sideEffects',
            'indications',
            'categories' => function ($query) {
                $query->select(['categories.id', 'categories.name']);
            },
            'offers'
        ])
            ->searchByQueryString()
            ->sortByQueryString()
            ->filterByQueryString()
            ->paginate();
        if ($products) {
            return ResponseHelper::finalResponse('get products successfully',ProductResource::collection($products),true,Response::HTTP_OK);
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
        $product = Product::with([
            'media',
            'sideEffects',
            'indications',
            'categories' => function ($query) {
                $query->select(['categories.id', 'categories.name']);
            },
            'offers'
        ])->find($id);
        if ($product) {
            return ResponseHelper::finalResponse(
                'data fetched successfully',
                ProductResource::make($product),
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
    public function suggestsForYou()
    {
        $user = User::find(auth()->user()->id);
        $productIds = $user->favourites->flatMap(function ($favourite) {
            return $favourite->categories->flatMap(function ($category) {
                return $category->products;
            });
        })->pluck('id')->unique();
        $products = Product::whereIn('id', $productIds)->with(['media', 'offers', 'sideEffects', 'indications'])->paginate();
        return ResponseHelper::finalResponse('get data successfully', ProductResource::collection($products), true, 200);
    }
}
