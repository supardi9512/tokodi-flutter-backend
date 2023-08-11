<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
}
