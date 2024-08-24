<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class AuthController extends Controller
{
    public function __construct() {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function login(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed. Please check your input.',
                'errors' => $validator->errors(),
                'timestamp' => now()->toDateTimeString(),
            ], 422);
        }
        if (! $token = Auth::attempt($validator->validated())) {
            return response()->json([
                'status' => 'error',
                'message' => 'Incorrect email or password.',
                'detail' => 'Ensure that the email and password included in the request are correct',
                'error_code' => 'INVALID_CREDENTIALS',
                'timestamp' => now()->toDateTimeString(),
                'path' => $request->path(),
            ], 401);
        }

        return $this->createNewToken($token);
    }

    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,100',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|min:6',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed. Please check your input.',
                'errors' => $validator->errors(),
                'timestamp' => now()->toDateTimeString(),
                'path' => $request->path(),
            ], 422);
        }

        $user = User::create(array_merge(
            $validator->validated(),
            ['password' => bcrypt($request->password)]
        ));

        return response()->json([
            'status' => 'success',
            'message' => 'User successfully registered',
            'user' => $user,
            'timestamp' => now()->toDateTimeString(),
        ], 201);
    }

    public function logout() {
        $user = auth()->user();
        auth()->logout();

        return response()->json([
            'status' => 'success',
            'message' => 'User successfully signed out.',
            'user' => [
                'id' => $user->id,
                'username' => $user->name,
            ],
            'timestamp' => now()->toDateTimeString()
        ], 200);
    }

    public function refresh() {
        return $this->createNewToken(auth()->refresh());
    }

    public function user() {
        return response()->json(auth()->user());
    }

    protected function createNewToken($token){
        return response()->json([
            'status' => 'success',
            'message' => 'Login successful',
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
