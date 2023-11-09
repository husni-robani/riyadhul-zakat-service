<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //todo : create logic that user has been authenticated cannot login for the second time
    //todo : change the response success
    //todo : change all the parameter authenticated api documentation with bearer token
    public function login(LoginRequest $request){
        try {
            $cred = $request->only(['email', 'password']);
            if (! Auth::attempt($cred)){
                throw new AuthenticationException('field doesnt match with record');
            }
            $user = User::where('email', $request->get('email'))->first();

            $token = $user->createToken($user->email)->plainTextToken;

            return response([
                'success'=> true,
                'data' => [
                    'user' => [
                        "name" => $user->value('name'),
                        "email" => $user->value('email'),
                        "access_token" => $token,
                    ]
                ]
            ]);


        }catch (ModelNotFoundException | AuthenticationException | \Exception $exception){
            return response()->json([
                "errors" => [
                    "message" => $exception->getMessage()
                ]
            ]);
        }
    }

    public function logout(Request $request){
        try {
            auth()->user()->tokens()->delete();
            return response()->json([
                "success"=> true,
                "message" => "user logout"
            ]);
        }catch (AuthenticationException | \Exception $exception){
            return response()->json([
                "errors" => [
                    "message" => $exception->getMessage()
                ]
            ]);
        }
    }
}
