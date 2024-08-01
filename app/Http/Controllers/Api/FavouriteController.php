<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\toggleFavouriteRequest;
use App\Http\Resources\Api\ProductResource;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Response;

class FavouriteController extends Controller
{
    public function displayFavouriteProduct()
    {
        $user = User::where('id', auth()->user()->id)->first();
        $favouriteProducts = $user->favourites()->with('media')->paginate(10);
        if ($favouriteProducts->isNotEmpty()) {
            return ResponseHelper::finalResponse(
                'get data successfully',
                ProductResource::collection($favouriteProducts),
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

    public function toggleFavourite(toggleFavouriteRequest $request)
    {
        $data = $request->validated();
        $user = auth()->user();
        $user = User::find($user->id);
        $product = Product::find($data['product_id']);
        if ($product) {
            if ($user->favourites()->where('product_id', $product->id)->exists()) {
                $user->favourites()->detach($product);

                return ResponseHelper::finalResponse(
                    'Product removed from favourites',
                    null,
                    true,
                    Response::HTTP_OK
                );
            }
            $user->favourites()->attach($product);

            return ResponseHelper::finalResponse(
                'Product added to favourites',
                null,
                true,
                Response::HTTP_CREATED
            );
        }

        return ResponseHelper::finalResponse(
            'Product not found',
            null,
            true,
            Response::HTTP_OK
        );
    }
}
