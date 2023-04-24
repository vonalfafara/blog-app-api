<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function updateProfilePicture(Request $request) {
        $fields = $request->validate([
            'profile_picture' => 'nullable|string'
        ]);

        $user = User::find(auth()->user()->id);
        $user->update($request->all());

        $response = [
            'message' => 'User details updated'
        ];

        return response($response, 200);
    }
}
