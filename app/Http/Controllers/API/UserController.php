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
    /** 
     * Register api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function register(Request $request) 
    { 
        $validator = Validator::make($request->all(), [
            'fullname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response(['errors'=>$validator->errors()->all()], $this->unprocessableEntity);
        }

        $request['password']=Hash::make($request['password']);
        $user = User::create($request->toArray());

        $token = $user->createToken('Laravel Password Grant Client')->accessToken;
        $response = ['token' => $token];

        return response($response, $this->successStatus);

    }
    /** 
     * details api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function details() 
    { 
        $user = Auth::user(); 
        return response()->json(['success' => $user], $this->successStatus); 
    } 
}