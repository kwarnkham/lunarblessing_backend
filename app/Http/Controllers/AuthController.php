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

    public function loginWithGoogle(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'email']
        ]);

        $user = User::where('email', $data['email'])->first() ?? User::create($data);
        $user->tokens()->delete();
        $token = $user->createToken('google');
        return response()->json([
            'user' => $user,
            'token' => $token->plainTextToken
        ]);
    }

    public function checkToken(Request $request)
    {
        return response()->json($request->user());
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required'],
            'password' => ['required', 'confirmed']
        ]);
        $user = $request->user();
        abort_unless(Hash::check($request->current_password, $user->password), ResponseStatus::UNAUTHORIZED->value, "Current password is incorrect");
        $user->password = $request->password;
        $user->save();
        return response()->json($user);
    }

    public function fbDataDelete(Request $request)
    {
        $signed_request = $request->signed_request;
        $data = parse_signed_request($signed_request);
        $user_id = $data['user_id'];

        $confirmation_code = uniqid(); // unique code for the deletion request
        $status_url = env('APP_URL') . '/deletion?id=' . $confirmation_code; // URL to track the deletion
        $data = array(
            'url' => $status_url,
            'confirmation_code' => $confirmation_code
        );

        function base64_url_decode($input)
        {
            return base64_decode(strtr($input, '-_', '+/'));
        }
        function parse_signed_request($signed_request)
        {
            list($encoded_sig, $payload) = explode('.', $signed_request, 2);

            $secret = "13c76a0b28cea4e23ca07451888c2bba"; // Use your app secret here

            // decode the data
            $sig = base64_url_decode($encoded_sig);
            $data = json_decode(base64_url_decode($payload), true);

            // confirm the signature
            $expected_sig = hash_hmac('sha256', $payload, $secret, $raw = true);
            if ($sig !== $expected_sig) {
                error_log('Bad Signed JSON signature!');
                return null;
            }

            return $data;
        }

        return response()->json($data);
    }
}
