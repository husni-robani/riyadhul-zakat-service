<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTransactionRequest;
use App\Http\Resources\TransactionResource;
use App\Models\Donor;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Nette\Schema\ValidationException;
use App\Traits\ApiResponse;

class TransactionController extends Controller
{
    use ApiResponse;
    public function index(Request $request)
    {
        try {
            $transactions = Transaction::all();

            return $this->responseSuccess(
                'get all transaction success',
                200,
                [
                    "transactions" => TransactionResource::collection($transactions)
                ]
            );
        } catch (\Exception $exception) {
            return $this->responseFailed(
                $exception->getMessage(),
                400,
                $exception->getMessage()
            );
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

            return $this->responseSuccess(
                'create new transaction success',
                201,
                [
                    'transaction' => $transaction
                ]
            );
        } catch (ModelNotFoundException|\Exception|ValidationException $exception) {
            $statusCode = $exception instanceof ModelNotFoundException ? 404 : ($exception instanceof ValidationException ? 422 : 400);

            return $this->responseFailed(
                $exception->getMessage(),
                $statusCode,
                $exception->getMessage()
            );
        }
    }

    public function getDonorTransactions(Request $request, $donorId)
    {
        try {
            $donor = Donor::findOrFail($donorId);

            return $this->responseSuccess(
                'get transactions by donor success',
                200,
                [
                    'donor_transactions' => TransactionResource::collection($donor->transactions->all())
                ]
            );
        } catch (ModelNotFoundException|\Exception $exception) {
            return $this->responseFailed(
                $exception->getMessage(),
                400,
                [
                    $exception->getMessage()
                ]
            );
        }
    }
}
