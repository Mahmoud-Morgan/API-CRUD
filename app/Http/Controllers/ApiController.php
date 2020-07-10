<?php

namespace App\Http\Controllers;

use JWTAuth;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterAuthRequest;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;
use Exception;

class ApiController extends Controller
{   

    /**
     * using auth middleware for any function except login and register
     */
    public function __construct() {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

  	/**
     * register new users after validating data with RegisterAuthRequest
     * and redirct new user to login function
     * @param  RegisterAuthRequest
     * @return [type]
     */
    public function register(RegisterAuthRequest $request)
    {          
        try{
            $user           = new User();
            $user->name     = $request->name;
            $user->email    = $request->email;
            $user->password = bcrypt($request->password);
            $user->save();
            return $this->login($request); 
        }catch(\Exception $e){
            $data['success'] = false;
            $data['message'] = 'registration error :'.$e->getMessage();
            return response()->json($data); 
        }
    }

    /**
     * login users after validation and generate jwt  
     * @param  Request
     * @return [type]
     */
    public function login(Request $request)
    {
        $input     = $request->only('email', 'password');
        $jwt_token = null;
 
        if (!$jwt_token = JWTAuth::attempt($input)) {
            $data['success'] = false;
            $data['message'] = 'Invalid Email or Password';
            return response()->json($data);  
        }
        
        $data['success'] = true;
        $data['token'] = $jwt_token;
        return response()->json($data);
    }

    /**
     * @return [type]
     */
    public function logout() {
        auth()->logout();
        $data['success'] = true;
        $data['message'] = 'User successfully signed out';
        return response()->json($data);
    }


    /**
     * return user info
     * @param  Request
     * @return [type]
     */
    public function getAuthUser(Request $request)
    {
        $data['success'] = true;
        $data['user_info'] = auth()->user();
        return response()->json($data);
    }

}
