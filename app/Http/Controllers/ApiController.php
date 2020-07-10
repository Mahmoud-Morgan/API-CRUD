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
        //start transaction
        DB::beginTransaction();
        try{
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->save();
            DB::commit();
            return $this->login($request); 
        }catch(\Exception $e){
            DB::rollback();
            return response()->json([
            'success' => false,
            'message' => 'registration error :'.$e->getMessage(),
            ], Response::HTTP_Unprocessable_Entity); //422
        }
    }

    /**
     * login users after validation and generate jwt  
     * @param  Request
     * @return [type]
     */
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

    /**
     * @return [type]
     */
    public function logout() {
        auth()->logout();

        return response()->json([
        	'success' => true,
        	'message' => 'User successfully signed out'
        ], Response::HTTP_OK);
    }


    /**
     * return user info
     * @param  Request
     * @return [type]
     */
    public function getAuthUser(Request $request)
    {
        
        return response()->json([
            'success' => true,
            'user_info' => auth()->user()           
        ], Response::HTTP_OK);
    }

}
