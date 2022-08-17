<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function update(UpdateUserRequest $request)
    {
        $data = $request->validated();
        $user = $request->user();
        $user->update($data);
        return response()->json($user);
    }

    public function changeSetting(Request $request, User $user)
    {
        $data = $request->validate([
            'telegram_notify' => ['boolean']
        ]);
        $user->update($data);
        return response()->json($user->fresh());
    }
}
