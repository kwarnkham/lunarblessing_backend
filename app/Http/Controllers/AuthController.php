<?php

namespace App\Http\Controllers;

use App\Enums\ResponseStatus;
use App\Http\Requests\LoginFormRequest;
use App\Http\Requests\RegisterFormRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(RegisterFormRequest $request)
    {
        $data = $request->validated();
        $user = User::create($data);
        $token = $user->createToken('login');
        return response()->json([
            'user' => $user,
            'token' => $token->plainTextToken
        ]);
    }

    public function login(LoginFormRequest $request)
    {
        $user = User::where('mobile', $request->mobile)->first();
        abort_unless(Hash::check($request->password, $user->password), ResponseStatus::UNAUTHENTICATED->value);
        $user->tokens()->delete();
        $token = $user->createToken('login');
        return response()->json([
            'user' => $user,
            'token' => $token->plainTextToken
        ]);
    }

    public function loginWithFacebook(Request $request)
    {
        $data = $request->validate([
            'fb_login_id' => ['required']
        ]);

        $user = User::where('fb_login_id', $data['fb_login_id'])->first() ?? User::create($data);
        $user->tokens()->delete();
        $token = $user->createToken('fb');
        return response()->json([
            'user' => $user,
            'token' => $token->plainTextToken
        ]);
    }

    public function checkToken(Request $request)
    {
        return response()->json($request->user());
    }
}
