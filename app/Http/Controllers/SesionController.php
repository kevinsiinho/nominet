<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;

class SesionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $response = ["status"=>0,"msg"=>""];
        $data = json_decode($request->getContent());
        $user=User::where('email',$data->email)->first();

        if($user){
            if(Hash::check($data->password, $user->password)){
                $token = $user->createToken("Example",['user' => $user]);
                $response["status"]=1;
                $response["msg"]=$token->plainTextToken;
            }else{
                $response["msg"]="Crenciales incorrectas";
            }
        }else{
            $response["msg"]="Usuario no encontrado.";
        }
        return response()->json($response);
    }


    /**
     * Update the specified resource in storage.
     */
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json(["msn" => "Vuelve pronto"]);

    }

}
