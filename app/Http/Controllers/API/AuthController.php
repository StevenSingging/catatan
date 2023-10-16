<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Auth;
use App\Models\User;
class AuthController extends Controller
{
   public function userLogin(Request $request)
   {
       $input = $request->all();
        $vallidation = Validator::make($input,[
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if($vallidation->fails()){
            return response()->json(['error' => $vallidation->errors()],422);
        }

        if (Auth::attempt(['email' => $input['email'],'password' => $input['password']])) {

            $user  = Auth::user();

            $success['token'] = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
            'success' => true,
            'message' => 'Sukses Login',
            'data' => $success
            ]);
        }else{
            return response()->json([
            'success' => false,
            'message' => 'Kesalahan',
            'data' => null
            ]);
        }

   }

   public function userRegister(Request $request)
   {
        $input = $request->all();
        $vallidation = Validator::make($input,[
            'email' => 'required|email',
            'password' => 'required',
            'name' => 'required',
            'role' => 'required'
        ]);

        if($vallidation->fails()){
            return response()->json(['error' => $vallidation->errors()],422);
        }

        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);

        $success['token'] = $user->createToken('auth_token')->plainTextToken;
        $success['name'] = $user->name;
        
        return response()->json([
            'success' => true,
            'message' => 'Sukses Register',
            'data' => $success
        ]);

   }

  public function userDetails()
  {
       $user  = Auth::user();
       return response()->json(['data' => $user]);
  }   

  public function logout(Request $request)
  {
      $request->user()->currentAccessToken()->delete();
      
      return response()->json(['success' => 'logout']);
  }
}