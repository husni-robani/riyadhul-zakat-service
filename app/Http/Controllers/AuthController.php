<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Traits\ApiResponse;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
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
}
