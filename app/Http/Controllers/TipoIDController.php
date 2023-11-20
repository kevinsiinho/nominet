<?php

namespace App\Http\Controllers;
use App\Models\TipoID;
use Illuminate\Http\Request;

class TipoIDController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      $tipoids=TipoID::all();
      return response()->json($tipoids);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $response = ["status"=>0,"msg"=>""];
        $data = json_decode($request->getContent());
        if($data){
            $tipoid = new TipoID();
            $tipoid->name = $data->name;
            if ($tipoid->save()) {
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
        $tipoid = TipoID::find($id);
        if(!$tipoid){
            return response()->json(["message"=>"No encontrado"]);
        }
        return response()->json($tipoid);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $response = ["status"=>0,"msg"=>""];
        $data = json_decode($request->getContent());
        if($data){
            $tipoid =TipoID::find($id);
            $tipoid->name = $data->name;
            if ($tipoid->save()) {
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
        $tipo =TipoID::find($id);
        $tipo->delete();
        return response()->json(["message"=>"Eliminado con exito"]);
    }
}
