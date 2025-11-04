<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;

class AccessTokensController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:255',
            'password' => 'required|string|min:6',
            'device_name' => 'nullable|string|max:255',
            'abilities' =>'nullable|array',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            $device_name = $request->post('device_name', $request->userAgent());
            $token = $user->createToken($device_name,$request->post('abilities'));

            return response()->json([
                'code' => 1,
                'token' => $token->plainTextToken,
                'user' => $user,
            ], 201);
        }

        return response()->json([
            'code' => 0,
            'message' => 'Invalid credentials',
        ], 401);
    }
    public function destroy($token = null)
    {
        $user = Auth::guard('sanctum')->user();
        if ($token == null) {
            $user->currentAccessToken()->delete();
            return;
        }
        $personalAccessToken = PersonalAccessToken::findToken($token);
        if (
            $user->id == $personalAccessToken->tokenable_id
            && get_class($user) == $personalAccessToken->tokenable_type
        ) {
            $personalAccessToken->delete();
        }
    }

}
