<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum', ['except' => ['login','checkEmail']]);
    }

    public function checkEmail(Request $request)
    {

    }

    public function login(Request $request)
    {
        try {
            $request->validate([
                'email'    => 'email|required',
                'password' => 'required'
            ]);

            $user = User::where('email', $request->email)->first();
            if (!$user) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'User not found'
                ], 404);
            }

            if (!Hash::check($request->password, $user->password)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Invalid credentials'
                ], 401);
            }

            $tokenResult = $user->createToken('myPOS-token')->plainTextToken;
            $user = [
                'id'               => $user->id,
                'name'             => $user->name,
                'email'            => $user->email,
                'group_permission' => $user->permission_group_id,
                'user_type'        => $user->user_type,
            ];

            return response()->json([
                'status' => 'success',
                'token'  => $tokenResult,
                'user'   => $user
            ], 200);
        } catch (Exception $error) {
            return response()->json([
                'status' => 'error',
                'message' => $error->getMessage(),
            ], 403);
        }
    }

    public function changePassword(Request $request)
    {
        $data = $request->all();
        $user = Auth::guard('api')->user();

        if( isset($data['old_password']) && !empty($data['old_password']) && $data['old_password'] !== "" && $data['old_password'] !=='undefined') {
            $check  = Auth::guard('web')->attempt([
                'email' => $user->email,
                'password' => $data['old_password']
            ]);
            if($check && isset($data['new_password']) && !empty($data['new_password']) && $data['new_password'] !== "" && $data['new_password'] !=='undefined') {
                $user->password = ($data['new_password']);
                $user->save();
                $tokenResult = $user->createToken('myPOS-token')->plainTextToken;

                return json_encode(array('access_token' => $tokenResult)); //sending the new token
            }
            else {
                return "Wrong password information";
            }
        }
        return "Wrong password information";
    }

    public function logoutUser(Request $request)
    {
        $token = $request->user()->currentAccessToken()->delete();
        return $token;
    }
}
