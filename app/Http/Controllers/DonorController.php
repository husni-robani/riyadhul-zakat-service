<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDonorRequest;
use App\Http\Requests\UpdateDonorRequest;
use App\Http\Resources\DonorResource;
use App\Models\Donor;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Traits\ApiResponse;

class DonorController extends Controller
{
    use ApiResponse;
    public function index()
    {
        return $this->responseSuccess('success to get all donor', 200, [
            "donors" => DonorResource::collection(Donor::all())
        ]);
    }

    public function store(StoreDonorRequest $request)
    {
        try {

            $donor = Donor::create($request->all());

            return $this->responseSuccess(
                'create donor successful',
                201,
                new DonorResource($donor)
            );

        } catch (Exception $exception) {
            return $this->responseFailed(
                $exception->getMessage(),
                400,
                [
                    $exception->getMessage()
                ]
            );
        }
    }

    public function show(Request $request, $donorId)
    {
        try {
            $donor = Donor::findOrFail($donorId);

            return $this->responseSuccess(
                'get donor success',
                200,
                new DonorResource($donor)
            );
        } catch (ModelNotFoundException|Exception $exception) {
            return $this->responseFailed(
                $exception->getMessage(),
                400,
                $exception->getMessage()
            );
        }
    }

    public function update(UpdateDonorRequest $request, $donorId)
    {
        try {
            $donor = Donor::findOrFail($donorId);
            $donor->update($request->all());

            return $this->responseSuccess(
                'update donor success',
                201,
                new DonorResource($donor)
            );
        } catch (ModelNotFoundException|Exception $exception) {
            return $this->responseFailed(
                $exception->getMessage(),
                400,
                $exception->getMessage()
            );
        }
    }

    public function destroy(Request $request, $donorId)
    {
        try {
            $donor = Donor::findOrFail($donorId);
            $donor->delete();

            return $this->responseSuccess(
                'delete donor success',
                200,
                ''
            );
        } catch (ModelNotFoundException|Exception $exception) {
            $statusCode = $exception instanceof ModelNotFoundException ? 404 : 400;

            return $this->responseFailed(
                $exception->getMessage(),
                $statusCode,
                $exception->getMessage()
            );
        }
    }

    public function transactionStatusApprove(Request $request, $donorId, $transactionId)
    {
        try {
            $donor = Donor::findOrFail($donorId);
            $transaction = $donor->transactions()->findOrFail($transactionId);
            $transaction->setAttribute('status', true);
            $transaction->save();

            return $this->responseSuccess(
                'transaction approved',
                201,
                ''
            );
        } catch (ModelNotFoundException|Exception $exception) {
            return $this->responseFailed(
                $exception->getMessage(),
                404,
                ''
            );
        }
    }
}
