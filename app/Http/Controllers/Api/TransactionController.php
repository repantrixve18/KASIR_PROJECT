<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.qty' => 'required|integer|min:1',
            'paid' => 'required|numeric',
        ]);

        $transaction = DB::transaction(function () use ($validated) {
            $total = 0;
            $itemsData = [];

            foreach ($validated['items'] as $item) {
                $product = Product::findOrFail($item['product_id']);
                $subtotal = $product->price * $item['qty'];
                $total += $subtotal;

                $itemsData[] = [
                    'product_id' => $product->id,
                    'qty' => $item['qty'],
                    'price' => $product->price,
                    'subtotal' => $subtotal,
                ];

                // Kurangi stok produk
                $product->decrement('stock', $item['qty']);
            }

            $transaction = Transaction::create([
                'invoice_number' => 'INV-' . strtoupper(uniqid()),
                'total' => $total,
                'paid' => $validated['paid'],
                'change' => $validated['paid'] - $total,
            ]);

            foreach ($itemsData as $data) {
                $transaction->items()->create($data);
            }

            return $transaction;
        });

        return response()->json($transaction->load('items.product'), 201);
    }
}