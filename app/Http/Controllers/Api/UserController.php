<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\logUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function index(){
        return response()->json([
            "success"=>true,
            "messgae"=>"Liste d'utilisateur",
            "data"=>User::all()
        ]);
    }

    public function register(StoreUserRequest $request){

        try{
            $user = new User();
            $user->name = $request->name;
            $user->email= $request->email;
            $user->password = $request->password;
            $user->save();
            return response()->json([
                "succes"=>false,
                "message"=>"votre compte a été créer avec success !",
                "data"=>$user
            ]);
        }catch(Exception $e){
            return response()->json($e);
        }
    }


    public function login(logUserRequest $request){
        try{
            if(auth()->attempt($request->only(['email', 'password']))){
                $user = auth()->user();
                $token = $user->createToken('MA_CLE_SECRETE_API')->plainTextToken;
                return response()->json([
                    "succes"=>false,
                    "message"=>"Connexion ressui",
                    "token"=>$token,
                    "data"=>$user,
                ]);
            }else{
                return response()->json([
                    "succes"=>false,
                    "message"=>"Information non valide",
                ]);
            }
        }catch(Exception $e){
            return response()->json($e);
        }
    }

}
