<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
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
}
