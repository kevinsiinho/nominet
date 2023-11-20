<?php
namespace App\Http\Controllers;
use App\Models\User;
use App\Models\HorasExtras;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users=User::all();
        return response()->json($users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $response = ["status"=>0,"msg"=>""];
        $data = json_decode($request->getContent());
        if($data){
            $user = new User();
            $user->tipoid=$request->tipoid;
            $user->id=$request->id;
            $user->password=$request->id;
            $user->name=$request->name;
            $user->lastname=$request->lastname;
            $user->email=$request->email;
            $user->salario=$request->salario;
            $user->cargo=$request->cargo;
            if ($user->save()) {
                $response["status"] = 1;
                $response["msg"] = "Datos guardados exitosamente.";
            } else {
                $response["msg"] = "Error al guardar los datos, verificar.";
            }
        }else{
            $response["msg"]="Error al guardar los datos, verificar.";
        }
        return response()->json($response);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = User::find($id);
        if(!$user){
            return response()->json(["message"=>"No encontrado"]);
        }
        return response()->json($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $response = ["status"=>0,"msg"=>""];
        $data = json_decode($request->getContent());
        if($data){
            $user = User::find($id);
            $user->tipoid=$request->tipoid;
            $user->id=$request->id;
            $user->password=$request->id;
            $user->name=$request->name;
            $user->lastname=$request->lastname;
            $user->email=$request->email;
            $user->salario=$request->salario;
            $user->cargo=$request->cargo;
            if ($user->save()) {
                $response["status"] = 1;
                $response["msg"] = "Datos guardados exitosamente.";
            } else {
                $response["msg"] = "Error al guardar los datos, verificar.";
            }
        }else{
            $response["msg"]="Error al guardar los datos, verificar.";
        }
        return response()->json($response);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $tipo = User::find($id);
        $tipo->delete();
        return response()->json(["message"=>"Eliminado con exito"]);
    }
}
