<?php

namespace App\Http\Controllers;

use JWTAuth;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterAuthRequest;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;

class ApiController extends Controller
{
    public function __construct() {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    
 
    public function register(RegisterAuthRequest $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();
 
        return $this->login($request); 
    }

    public function login(Request $request)
    {
        $input = $request->only('email', 'password');
        $jwt_token = null;
 
        if (!$jwt_token = JWTAuth::attempt($input)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Email or Password',
            ], Response::HTTP_UNAUTHORIZED);
        }
 
        return response()->json([
            'success' => true,
            'token' => $jwt_token,
        ]);
    }

    public function logout() {
        auth()->logout();

        return response()->json([
        	'success' => true,
        	'message' => 'User successfully signed out'
        ], Response::HTTP_OK);
    }

    public function getAuthUser(Request $request)
    {
        
 
        return response()->json(auth()->user());
    }



}
