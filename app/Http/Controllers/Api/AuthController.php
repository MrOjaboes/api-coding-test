<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Traits\ApiResponder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    use ApiResponder;

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:users,email',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'validator_errors' => $validator->errors(),
            ]);
        } else {
           $user = User::create([
                'name' => str_replace(' ','',$request->name),
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
             return $this->successResponse($user);
        }
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'validator_errors' => $validator->errors(),
            ]);
        } else {
            $user = User::where('email', $request->email)->first();
            if (!$user || !Hash::check($request->password, $user->password)) {
                return response()->json([
                    'status' => 401,
                    'message' => 'Invalid Credentials!',
                ]);
            } else {
                $user->token = $user->createToken($user->name.' API Token', ['user'])->plainTextToken;
                return $this->successResponse($user);

            }
        }
    }

    public function logout()
    {
        
        auth()->user()->tokens()->delete();
        return ['message' => 'successfully logged out and the token was successfully deleted'];
    }
}
