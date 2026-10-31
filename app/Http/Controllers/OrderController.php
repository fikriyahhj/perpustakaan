<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Events\OrderPlaced;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'cart' => 'required|array|min:1',
            'cart.*.id' => 'required|exists:products,id',
            'cart.*.qty' => 'required|integer|min:1',
            'customer' => 'nullable|string|max:255',
            'discount' => 'nullable|numeric|min:0',
            'tax' => 'nullable|numeric|min:0',
            'other_fee' => 'nullable|numeric|min:0',
            'payment' => 'required|numeric|min:0',
            'payment_method' => 'required|in:cash,transfer,qris',
        ]);

        $order = DB::transaction(function () use ($validated) {
            $subtotal = 0;
            $items = [];

            foreach ($validated['cart'] as $cartItem) {
                $product = Product::findOrFail($cartItem['id']);

                $price = $product->price;
                $quantity = $cartItem['qty'];
                $itemSubtotal = $price * $quantity;

                $subtotal += $itemSubtotal;

                $items[] = [
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'sku' => $product->sku,
                    'price' => $price,
                    'quantity' => $quantity,
                    'subtotal' => $itemSubtotal,
                ];
            }

            $discount = $validated['discount'] ?? 0;
            $tax = $validated['tax'] ?? 0;
            $otherFee = $validated['other_fee'] ?? 0;

            $grandTotal = max(
                0,
                $subtotal - $discount + $tax + $otherFee
            );

            $payment = $validated['payment'];

            if ($payment < $grandTotal) {
                throw new \Exception('Pembayaran masih kurang.');
            }

            $order = Order::create([
                'transaction_number' => 'TRX-' . now()->format('YmdHis') . '-' . uniqid(),
                'customer' => $validated['customer'] ?? null,
                'subtotal' => $subtotal,
                'discount' => $discount,
                'tax' => $tax,
                'other_fee' => $otherFee,
                'grand_total' => $grandTotal,
                'payment' => $payment,
                'change' => $payment - $grandTotal,
                'payment_method' => $validated['payment_method'],
            ]);

            $order->items()->createMany($items);

            return $order;
        });

       event(new OrderPlaced($order, auth()->user()));  

        return response()->json([
            'message' => 'Pembayaran berhasil disimpan.',
            'order' => $order,
        ]);
    }
}