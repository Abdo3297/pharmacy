<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Filament\Notifications\Events\DatabaseNotificationsSent;

class StripeController extends Controller
{
    public function stripe($id)
    {
        $order = Order::find($id);
        if ($order) {
            if ($order->payment_status) {
                return ResponseHelper::finalResponse(
                    'This Order Already Paid',
                    null,
                    true,
                    Response::HTTP_OK
                );
            }
            Session::put('stripe_order_id', $order->id);
            $stripe = new \Stripe\StripeClient(config('stripe.stripe_sk'));
            $response = $stripe->checkout->sessions->create([
                'line_items' => [
                    [
                        'price_data' => [
                            'currency' => 'usd',
                            'product_data' => [
                                'name' => 'Order'
                            ],
                            'unit_amount' => ($order->total_amount) * 100,
                        ],
                        'quantity' => 1,
                    ],
                ],
                'mode' => 'payment',
                'success_url' => route('stripe.success') . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('stripe.cancel'),
            ]);
            if (isset($response->id) && $response->id != '') {
                return redirect($response->url);
            }
        }
        return redirect()->route('stripe.cancel');
    }
    public function success(Request $request)
    {
        $id = Session::get('stripe_order_id');
        $order = Order::find($id);
        if ($order) {
            if (isset($request->session_id)) {
                $stripe = new \Stripe\StripeClient(config('stripe.stripe_sk'));
                $response = $stripe->checkout->sessions->retrieve($request->session_id);
                $data = [
                    'payment_id' => $response['id'],
                    'payment_status' => true,
                    'payment_type' => 'stripe',
                ];
                // update `order` & decrement stock in `product`
                $order->update($data);
                foreach ($order->products as $product) {
                    $product->decrement('stock', $product->pivot->quantity);
                    $product->refresh();
                    $admin = User::where("is_admin", true)->first();
                    /* send notification that order done */
                    \Filament\Notifications\Notification::make()
                        ->icon('fas-cart-shopping')
                        ->iconColor('success')
                        ->title('New Order Done')
                        ->body('ID of order : ' . $response['id'])
                        ->sendToDatabase($admin);
                    event(new DatabaseNotificationsSent($admin));
                    /* send notification that stock decrease */
                    if ($product->stock <= $product->alert) {
                        \Filament\Notifications\Notification::make()
                            ->icon('fas-clock')
                            ->iconColor('warning')
                            ->title('Product is near to finish.')
                            ->body('Name : ' . $product->name)
                            ->sendToDatabase($admin);
                        event(new DatabaseNotificationsSent($admin));
                    }
                }
                return ResponseHelper::finalResponse(
                    'Payment Done',
                    $data,
                    true,
                    Response::HTTP_OK
                );
            }
        }
        return redirect()->route('stripe.cancel');
    }
    public function cancel()
    {
        return ResponseHelper::finalResponse(
            'Payment Failed',
            null,
            true,
            Response::HTTP_OK
        );
    }
}
