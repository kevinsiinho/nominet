<?php

namespace App\Http\Controllers;
use App\Models\TipoID;
use App\Models\User;
use App\Models\Llegadas;
use Carbon\Carbon;
use App\Models\HorasExtras;

use Illuminate\Http\Request;

class ExtrasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view("extras",['tipoids'=>TipoID::all()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
            $user=User::find($request->id);
            if($user!=null){
                $userllegada=Llegadas::find($user->id);
                if($userllegada==null){
                $llegada=new Llegadas();
                $llegada->id=$user->id;
                $llegada->name=$user->name;
                $llegada->llegada=Carbon::now();
                $llegada->save();
                return response()->json(['status' => 1, 'data' => $user->name]);
            } else {
                $horas = new HorasExtras();
                $entrada = Carbon::parse($userllegada->llegada);
                $actual=Carbon::now();
                $salida = Carbon::parse($actual);
                $cantidad = $entrada->diff($salida)->h;
                $horas->llegada=$entrada;
                $horas->salida=$salida;
                $horas->users=$user->id;
                if($cantidad<9){
                    $cantidad=0;
                    $horas->cantidad=$cantidad;
                    $horas->save();
                }elseif($cantidad>8){
                 $cantidad=$cantidad-8;
                 $horas->cantidad=$cantidad;
                 $horas->save();
                }
                 $deletellegada =Llegadas::find($user->id);
                 $deletellegada->delete();
                return response()->json(['status' => 2, 'data' => 'Gracias por tu labor']);
            }
        } else {
            return response()->json(['status' => 0, 'data' => 'Empleado no encontrado']);
        }
    }

    /**
     * Display the specified resource.
     */
        public function show()
        {
            return view('llegados')->with(['users' => Llegadas::all()]);
        }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {

    }
}
