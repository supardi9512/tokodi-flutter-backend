<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Helpers\ResponseFormatter;

class TransactionController extends Controller
{
    public function all(Request $request)
    {
        $id = $request->input('id');
        $limit = $request->input('limit', 6);
        $status = $request->input('status');

        if($id) {
            $transaction = Transaction::with(['items.product'])->find($id);

            if($transaction) {
                return ResponseFormatter::success(
                    $transaction,
                    'Transaction list data is available.'
                );
            } else {
                return ResponseFormatter::error(
                    null,
                    'Transaction list data is not available.',
                    404
                );
            }
        }

        $transaction = Transaction::with(['items.product'])->where('user_id', Auth::user()->id);

        if($status) {
            $transaction->where('status', $status);
        }

        return ResponseFormatter::success(
            $transaction->paginate($limit),
            'Transaction list data is available.'
        );
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'exists:products,id',
            'total_price' => 'required',
            'shipping_price' => 'required',
            'status' => 'required|in:PENDING,SUCCESS,CANCELLED,FAILED,SHIPPING,SHIPPED'
        ]);

        $transaction = Transaction::create([
            'user_id' => Auth::user()->id,
            'address' => $request->address,
            'total_price' => $request->total_price,
            'shipping_price' => $request->shipping_price,
            'status' => $request->status,
        ]);

        foreach($request->items as $product) {
            TransactionItem::create([
                'user_id' => Auth::user()->id,
                'product_id' => $product['id'],
                'transaction_id' => $transaction->id,
                'quantity' => $product['quantity']
            ]);
        }

        return ResponseFormatter::success(
            $transaction->load('items.product'), 
            'The transaction has been successfully added.'
        );
    }
}
