<?php

namespace App\Http\Controllers\api\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\traits\generalTrait;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;

class authController extends Controller
{
    use generalTrait;

    public function register(Request $request)
    {
        $rules = [
            'name'=>'required',
            'phone'=>'required|numeric|min:13|unique:users',
            'email'=>'required|unique:users',
            'password'=>'required|min:8',
            'book'=>'required'
        ];
        $code = rand(11111,99999);
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            return $this->returnValidationError($validator,__('test.errors.validation_error'));
        }
        $insertData = $request->all();
        $insertData['code'] = $code;
        $insertData['password'] = bcrypt($request->password);
        $id = User::insertGetId($insertData);
        $newUser = User::find($id);

        $credentials = request(['email', 'password']);

        if (! $token = auth('api')->attempt($credentials)) {
            return $this->returnError(401,"Unauthorized");
        }
        $newUser->token = 'bearer '.$token;
        // send code via mail
        return $this->returnData('user',$newUser);

    }

    public function checkCode(Request $request)
    {
        $rules = [
            'code'=>'required|min:5|exists:users',
        ];
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            return $this->returnValidationError($validator);
        }

        $id =  auth('api')->user()->id;
        $newUser = User::Where('id','=',$id)->where('code','=',$request->code)->first();
        if($newUser){
            User::where('id','=',$id)->update(['status'=>1]);
            return $this->returnData('user',$newUser);

        }else{
            return $this->returnError(401,"Wrong Code");
        }
        //logedIN

    }

    public function profile(Request $request)
    {
        // get user from DB
        if(auth('api')->check()){
            $id = auth('api')->user()->id;
            $user = User::find($id);
            return $this->returnData('user',$user);
        }else{
            return response()->json(['error' => 'Unauthorized'], 401);

        }
        
    }

    public function login(Request $request)
    {
        $rules = [
            'email'=>'required|exists:users',
            'password'=>'required|min:8',
        ];
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            return $this->returnValidationError($validator);
        }

        // check status of user
            $credentials = request(['email', 'password']);

            if (! $token = auth('api')->attempt($credentials)) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
            $user = User::find(auth('api')->user()->id);
            $user->token = 'bearer '.$token;
            return $this->returnData('user',$user);
        // return reponse check your mail
    }
    public function logout(Request $request)
    {
        auth('api')->logout();
        return $this->returnSuccessMessage("You have successfully logout");

    }

    public function updateProfile(Request $request)
    {
       $rules = [
        'name'=>'required',
        'phone'=>'required|numeric|min:13',
        'email'=>'required',
       ];
       $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            return $this->returnValidationError($validator);
        }
        $id = auth('api')->user()->id;

        try { 
            User::where('id','=',$id)->update($request->all());
          } catch(QueryException $ex){ 
            $message = $ex->getMessage(); 
            if(strpos($message,"'phone'") !== false){
                return $this->returnError(400,"phone already exists");
            }else{
                return $this->returnError(400,"Email already exists");
            }
          }

        $user = User::find($id);
        return $this->returnData('user',$user);


    }
}
