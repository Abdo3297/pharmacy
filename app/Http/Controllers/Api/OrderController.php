<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\storeOrderRequest;
use App\Http\Requests\Api\updateOrderRequest;
use App\Http\Resources\Api\OrderResource;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::OrderUser(auth()->user()->id)->with(['user'])->get();
        if ($orders) {
            return ResponseHelper::finalResponse(
                'data fetched successfully',
                OrderResource::collection($orders),
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

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $order = Order::OrderUser(auth()->user()->id)->with(['user'])->find($id);
        if ($order) {
            return ResponseHelper::finalResponse(
                'data fetched successfully',
                OrderResource::make($order),
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

    /**
     * Store a newly created resource in storage.
     */
    public function store(storeOrderRequest $request)
    {
        $data = $request->validated();
        DB::beginTransaction();
        try {
            $order = Order::create([
                'user_id' => $data['user_id'],
            ]);
            $items = [];
            foreach ($data['items'] as $item) {
                $product = Product::find($item['product_id']);
                if (! $product) {
                    DB::rollBack();

                    return ResponseHelper::finalResponse(
                        'product not found',
                        null,
                        true,
                        Response::HTTP_OK
                    );
                }
                if ($product->stock < $item['quantity']) {
                    DB::rollBack();

                    return ResponseHelper::finalResponse(
                        'this amount unavailable',
                        null,
                        true,
                        Response::HTTP_OK
                    );
                }
                $unitPrice = $product->unit_price;
                // Check for offers on the product
                $offers = $product->offers;
                foreach ($offers as $offer) {
                    if ($offer->discount_type == 'fixed') {
                        $unitPrice = max(0, $unitPrice - $offer->discount_value);
                    } elseif ($offer->discount_type == 'percentage') {
                        $unitPrice = max(0, $unitPrice * (1 - $offer->discount_value / 100));
                    }
                }

                $totalPrice = $item['quantity'] * $unitPrice;
                $items[$item['product_id']] = [
                    'quantity' => $item['quantity'],
                    'unit_price' => $unitPrice,
                    'total_price' => $totalPrice,
                ];
            }
            $order->products()->sync($items);
            $totalAmount = collect($items)->sum('total_price');
            $order->update(['total_amount' => $totalAmount]);
            DB::commit();

            return ResponseHelper::finalResponse(
                'order created successfully',
                [
                    'totalAmount' => $totalAmount,
                ],
                true,
                Response::HTTP_CREATED
            );
        } catch (\Exception $e) {
            DB::rollBack();

            return ResponseHelper::finalResponse(
                'Order creation failed',
                $e->getMessage(),
                true,
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(updateOrderRequest $request, $id)
    {
        $data = $request->validated();
        DB::beginTransaction();
        try {
            $order = Order::find($id);
            if (! $order) {
                DB::rollBack();

                return ResponseHelper::finalResponse(
                    'this order not found',
                    null,
                    true,
                    Response::HTTP_OK
                );
            }
            if ($order->user_id != auth()->user()->id) {
                DB::rollBack();

                return ResponseHelper::finalResponse(
                    'You Are Not Allowed',
                    null,
                    true,
                    Response::HTTP_FORBIDDEN
                );
            }
            $items = [];
            foreach ($data['items'] as $item) {
                $product = Product::find($item['product_id']);
                if ($product->stock < $item['quantity']) {
                    DB::rollBack();

                    return ResponseHelper::finalResponse(
                        'this amount unavailable',
                        null,
                        true,
                        Response::HTTP_OK
                    );
                }
                if (! $product) {
                    DB::rollBack();

                    return ResponseHelper::finalResponse(
                        'product not found',
                        null,
                        true,
                        Response::HTTP_OK
                    );
                }
                $unitPrice = $product->unit_price;
                // Check for offers on the product
                $offers = $product->offers;
                foreach ($offers as $offer) {
                    if ($offer->discount_type == 'fixed') {
                        $unitPrice = max(0, $unitPrice - $offer->discount_value);
                    } elseif ($offer->discount_type == 'percentage') {
                        $unitPrice = max(0, $unitPrice * (1 - $offer->discount_value / 100));
                    }
                }
                $totalPrice = $item['quantity'] * $unitPrice;
                $items[$item['product_id']] = [
                    'quantity' => $item['quantity'],
                    'unit_price' => $unitPrice,
                    'total_price' => $totalPrice,
                ];
            }
            $order->products()->sync($items);
            $totalAmount = collect($items)->sum('total_price');
            $order->update(['total_amount' => $totalAmount]);
            DB::commit();

            return ResponseHelper::finalResponse(
                'Order updated successfully',
                [
                    'totalAmount' => $totalAmount,
                ],
                true,
                Response::HTTP_OK
            );
        } catch (\Exception $e) {
            DB::rollBack();

            return ResponseHelper::finalResponse(
                'Order update failed',
                $e->getMessage(),
                true,
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $order = Order::find($id);
        if (! $order) {
            return ResponseHelper::finalResponse(
                'data not found',
                null,
                true,
                Response::HTTP_OK
            );
        }
        if ($order->user_id != auth()->user()->id) {
            return ResponseHelper::finalResponse(
                'You Are Not Allowed',
                null,
                true,
                Response::HTTP_FORBIDDEN
            );
        }
        $order->delete();

        return ResponseHelper::finalResponse(
            'data deleted successfully',
            null,
            true,
            Response::HTTP_OK
        );
    }
}
