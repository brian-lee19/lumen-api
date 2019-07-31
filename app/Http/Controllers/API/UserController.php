<?php
namespace App\Http\Controllers\API;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use App\User; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\RequestGuard;
use Validator;
use \Illuminate\Support\Facades\Hash as Hash;

class UserController extends Controller 
{
    public $successStatus = 200;
    public $unprocessableEntity = 422;
    /** 
     * login api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function login(Request $request) 
    {
        $user = User::where('email', $request->email)->first();

        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                $token = $user->createToken('Laravel Password Grant Client')->accessToken;
                $response = ['token' => $token];
                return response($response, $this->successStatus);
            } else {
                $response = "Password missmatch";
                return response($response, $this->unprocessableEntity);
            }

        } else {
            $response = 'User does not exist';
            return response($response, $this->unprocessableEntity);
        }
    }
}