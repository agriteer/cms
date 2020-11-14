<?php

namespace App\Http\Controllers;

use App\Models\User;
use JWTAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Exceptions\InvalidLoginException;

class AuthController extends Controller
{
    protected $model;

    public function __constructor(User $user)
    {
        $this->model = $user;
    }

    public function login(Request $request)
    {
        $token = JWTAuth::attempt($request->only(['username', 'password']));

        if (!$token) {
            throw new InvalidLoginException();
        }

        return $this->successResponse($token, 'Login successful', 200);
    }

    public function register(Request $request)
    {
        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'password' => bcrypt($request->password),
            'status' => true,
            'role_id' => 1
        ]);

        return $user;
    }

    public function logout(): JsonResponse
    {
        auth()->logout();

        $data = [
            'status' => true,
            'code' => 200,
            'data' => [
                'message' => 'Successfully logged out'
            ],
            'err' => null
        ];

        return $this->successResponse($data, 'Successfully logged out');
    }

    public function refresh(): JsonResponse
    {
        $data = [
            'status' => true,
            'code' => 200,
            'data' => [
                '_token' => auth()->refresh()
            ],
            'err' => null
        ];

        return $this->successResponse($data, 'Successfully refreshed');
    }

    public function home()
    {
        $data = [
            'status' => true,
            'data' => null,
            'err' => null
        ];

        return $this->successResponse($data, 'Successfully refreshed', 200);
    }
}
