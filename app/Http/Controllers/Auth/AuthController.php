<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\UserModel;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function login(LoginRequest $request)
    {

        $user = UserModel::getUserByEmail($request->get("email"));

        if (!is_object($user) || !Hash::check($request->get("password"), $user->password)) {
            return ResponseHelper::returnError('Invalid credentials', Response::HTTP_UNAUTHORIZED);
        }

        $token = $user->createToken('api');

        return ResponseHelper::returnSuccess([
            'token' => $token->plainTextToken
        ]);

    }

    public function register(RegisterRequest $request)
    {

        $data             = $request->validated();

        $data["password"] = Hash::make($data["password"]);

        $user = UserModel::create($data);

        return ResponseHelper::returnSuccess([
            'user' => $user
        ], Response::HTTP_CREATED);
    }


}
