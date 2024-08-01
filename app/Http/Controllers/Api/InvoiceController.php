<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Response;
use LaravelDaily\Invoices\Classes\InvoiceItem;
use LaravelDaily\Invoices\Classes\Party;
use LaravelDaily\Invoices\Invoice;

class InvoiceController extends Controller
{
    public function index($orderId)
    {
        $admin = User::where('is_admin', true)->first();
        $seller = new Party([
            'custom_fields' => [
                'name' => $admin->name,
                'email' => $admin->email,
            ],
        ]);
        $user = User::where('id', auth()->user()->id)->with([
            'orders' => function ($query) use ($orderId) {
                $query->where('payment_status', true)->where('id', $orderId)->with([
                    'products' => function ($query) {
                        $query->with('offers');
                    },
                ]);
            },
        ])->first();
        if ($user->orders->isEmpty()) {
            return ResponseHelper::finalResponse(
                'order not found',
                null,
                true,
                Response::HTTP_OK
            );
        }
        $buyer = new Party([
            'custom_fields' => [
                'name' => $user->name,
                'phone' => $user->phone,
                'email' => $user->email,
            ],
        ]);
        $items = [];
        foreach ($user->orders as $order) {
            foreach ($order->products as $product) {
                $item = InvoiceItem::make($product->name)
                    ->pricePerUnit($product->unit_price)
                    ->quantity($product->pivot->quantity);
                // $offer = $product->offer;
                $offers = $product->offers;
                foreach ($offers as $offer) {
                    if ($offer) {
                        if ($offer->discount_type == 'percentage') {
                            $item->discountByPercent($offer->discount_value);
                        }
                    }
                }
                $items[] = $item;
            }
        }
        $invoice = Invoice::make()
            ->seller($seller)
            ->buyer($buyer)
            ->status(__('invoices::invoice.paid'))
            ->series('A')
            ->serialNumberFormat('{SERIES}.{SEQUENCE}')
            ->dateFormat('d-m-Y')
            ->currencySymbol('$')
            ->logo(public_path('vendor/invoices/logo.png'))
            ->addItems($items);

        return $invoice->download();
    }
}
