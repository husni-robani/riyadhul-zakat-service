<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Database\QueryException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\UnauthorizedException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Response as StatusCode;

class AuthController extends Controller
{
    use ApiResponse;

    /**
     * Handle an authentication attempt.
     *
     * @return JsonResponse
     */
    public function login(LoginRequest $request)
    {
        if (!Auth::attempt($request->validated())) {
            throw new HttpResponseException(
                $this->responseFailed(
                    'Credentials not match',
                    Response::HTTP_UNAUTHORIZED,
                    null
                )
            );
        }

        $token = Auth::user()->createToken('authToken')->plainTextToken;

        return $this->responseSuccess(
            'User login successfully',
            StatusCode::HTTP_OK,
            [
                'user' => [
                    'name' => Auth::user()->name,
                    'email' => Auth::user()->email,
                    'access_token' => $token,
                ],
            ]
        );
    }

    /**
     * Handle logout request.
     *
     * @return JsonResponse
     */
    public function logout()
    {
        Auth::user()->tokens()->delete();

        return $this->responseSuccess(
            'User logout successfully',
            StatusCode::HTTP_OK,
            null
        );
    }

    /**
     * Handle get user profile request.
     *
     * @return JsonResponse
     */
    public function userProfile()
    {
        return $this->responseSuccess(
            'Success get user profile',
            StatusCode::HTTP_OK,
            Auth::user()
        );
    }

    public function register(RegisterRequest $request){
        if (!Gate::allows('register-user')){
            return $this->responseFailed('Unauthorized for this action', 401, [
                throw new UnauthorizedException("unauthorized")
            ]);
        }

        try {
            $user = User::create($request->only(['name', 'email', 'password']));
        }catch (QueryException | \Exception $exception){
            return $this->responseFailed('create user failed', 400, [
                $exception->getMessage()
            ]);
        }
        return $this->responseSuccess('create user successful', 201, [
            "user" => new UserResource($user)
        ]);
    }
}
