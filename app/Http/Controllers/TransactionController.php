<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTransactionRequest;
use App\Http\Resources\TransactionResource;
use App\Models\Donor;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Nette\Schema\ValidationException;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        try {
            $transactions = Transaction::all();

            return response()->json([
                'message' => 'get all transaction success',
                'data' => [
                    'transactions' => TransactionResource::collection($transactions),
                ],
            ], 200);
        } catch (\Exception $exception) {
            return response()->json([
                'errors' => $exception->getMessage(),
            ], 400);
        }
    }

    public function store(StoreTransactionRequest $request)
    {
        try {
            $donor = Donor::findOrFail($request->get('donors_id'));
            $transaction = $donor->transactions()->create([
                'donors_id' => $donor->get('id'),
                'donation_type' => $request->get('donation_type'),
                'payment_method' => $request->get('payment_method'),
                'total_money' => $request->get('total_money'),
                'total_good' => $request->get('total_good'),
                'status' => false,
            ]);

            return response()->json([
                'message' => 'create new transaction successful',
                'data' => new TransactionResource($transaction),
            ]);
        } catch (ModelNotFoundException|\Exception|ValidationException $exception) {
            $statusCode = $exception instanceof ModelNotFoundException ? 404 : ($exception instanceof ValidationException ? 422 : 400);

            return response()->json([
                'errors' => $exception->getMessage(),
            ], $statusCode);
        }
    }

    public function getDonorTransactions(Request $request, $donorId)
    {
        try {
            $donor = Donor::findOrFail($donorId);

            return [
                'data' => [
                    'donor_transactions' => TransactionResource::collection($donor->transactions->all()),
                ],
            ];
        } catch (ModelNotFoundException|\Exception $exception) {
            return response()->json([
                'errors' => $exception->getMessage(),
            ]);
        }
    }
}
