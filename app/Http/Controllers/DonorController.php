<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDonorRequest;
use App\Http\Resources\DonorResource;
use App\Models\Donor;
use Illuminate\Http\Request;

class DonorController extends Controller
{
    public function index(){
        return DonorResource::collection(Donor::all());
    }

    public function store(StoreDonorRequest $request){
        $donor = Donor::create($request->all());
        return new DonorResource($donor);
    }
}
