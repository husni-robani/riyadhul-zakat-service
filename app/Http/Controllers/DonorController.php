<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDonorRequest;
use App\Http\Requests\UpdateDonorRequest;
use App\Http\Resources\DonorResource;
use App\Models\Donor;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class DonorController extends Controller
{
    public function index(){
        return response()->json([
            "message" => "success to get donors",
            "data" => [
                "donors" => DonorResource::collection(Donor::all())
            ]
        ], 200);
    }

    public function store(StoreDonorRequest $request){
        try {

            $donor = Donor::create($request->all());
            return response()->json([
                "message" => "create donor successful",
                "data" => new DonorResource($donor)
            ], 201);

        }catch (Exception $exception){
            return \response()->json([
                "errors" => $exception->getMessage()
            ], 404);
        }
    }

    public function show(Request $request, $donorId){
        try{
            $donor = Donor::findOrFail($donorId);
            return \response()->json([
                "message" => "success get donor",
                "data" => new DonorResource($donor)
            ]);
        }catch (ModelNotFoundException|Exception $exception){
            return \response()->json([
                "errors" => [
                    "message" => $exception->getMessage(),
                ]
            ], 404);
        }
    }

    public function update(UpdateDonorRequest $request, $donorId){
        try{
            $donor = Donor::findOrFail($donorId);
            $donor->update($request->all());
            return response()->json([
                "message" => "update donor successful",
                "data" => new DonorResource($donor)
            ]);
        }catch (ModelNotFoundException | Exception $exception){
            return response()->json([
                "errors" => [
                    "message" => $exception->getMessage()
                ]
            ], 404);
        }
    }

    public function destroy(Request $request, $donorId){
        try{
            $donor = Donor::findOrFail($donorId);
            $donor->delete();
            return response('', 204);
        }catch (ModelNotFoundException | Exception $exception){
            $statusCode = $exception instanceof ModelNotFoundException ? 404 : 400;
            return response()->json([
                "errors" => [
                    "message" => $exception->getMessage()
                ]
            ], $statusCode);
        }
    }

    public function transactionStatusApprove(Request $request, $donorId, $transactionId){
        try {
            $donor = Donor::findOrFail($donorId);
            $transaction = $donor->transactions()->findOrFail($transactionId);
            $transaction->setAttribute('status', true);
            $transaction->save();
            return response()->json('', 204);
        }catch (ModelNotFoundException | Exception $exception){
            return response()->json([
                "errors" => $exception->getMessage()
            ], 400);
        }
    }
}
