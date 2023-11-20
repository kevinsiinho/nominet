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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    if (auth()->check()){
    $response = ["status" => 0, "msg" => "", "data" => ""];
    $valorh = null;
    $total = null;
    $cantidad = null;
    $msn = null;
    $msn2 = null;
    $msn3 = null;
    $data = json_decode($request->getContent());
    $entrada = Carbon::parse($request->llegada);
    $salida = Carbon::parse($request->salida);
    $horaEntrada = Carbon::parse($request->llegada)->format('H:i:s');
    $horaSalida = Carbon::parse($request->salida)->format('H:i:s');

    $cantidad = $entrada->diffInHours($salida);
    $valorh = auth()->user()->salario/30/8;

    // Calcular extras días domingos o festivos 75%
    if ($entrada->isSunday() || $this->esFestivo($entrada)) {
        $msn = "Recargo Dominical o festivo";
        $cantidad = $cantidad - 1;
        $valorh = $valorh + ($valorh * 0.75);
        if ($horaEntrada >= '06:00:00' && $horaEntrada <= '12:00:00' && $cantidad < 9) {
            //trabaja 8 horas un dominical o festivo
            $total = $valorh * $cantidad;
        } else if ($horaEntrada >= '06:00:00' && $horaSalida <= '21:00:00' && $entrada->isSameDay($salida)) {
           //trabaja horas extras diurnas un dominical o festivo
            $total = $valorh * 8;
            $valorh = $valorh + ($valorh * 1);
            $msn2 = "Hora extra dominical o festivo diurna";

            $total = $total + ($valorh * ($cantidad - 8));
        } else if ($horaEntrada >= '06:00:00' && $horaSalida > '21:00:00') {
            $va2=$valorh;
            $total=$valorh*8;
            $after = Carbon::parse('21:00:00');
            // Calcular la diferencia en extras
            $cant = $salida->diffInHours($after);
            $valorh=$valorh+($valorh*1);
            $msn2="Hora extra dominical o festivo diurna";
            $total=$total+($valorh*($cantidad-8-$cant));
            $valorh=$va2+($va2*1.5);
            $msn3="Hora extra dominical o festivo nocturna";
            $total=$total+($valorh*$cant);
        } else{
            //trabaja en las noches desde las 9 pm hasta el dia siguiente maximo 6am
            $valorh = $valorh + ($valorh * 1.1);  //verificar
            $cantidad = $cantidad + 1;
            $msn2 = "Hora dominical o festivo nocturno";
            $total = $valorh * $cantidad;
        }
    } else {
        //sino es festivo o dominical
        $cantidad = $cantidad - 1;
        if ($horaEntrada >= '06:00:00' && $horaEntrada <= '12:00:00' && $cantidad < 9) {
            //trabaja 8 horas normales
            $total = $valorh * $cantidad;
        } else if ($horaEntrada >= '06:00:00' && $horaSalida <= '21:00:00' && $entrada->isSameDay($salida)) {
            //trabaja 8 horas más extras sin pasarse de las 9pm
            $total = $valorh * 8;
            $valorh = $valorh + ($valorh * 0.25);
            $msn = "Hora extra diurna";
            $total = $total + ($valorh * ($cantidad - 8));
        } else if ($horaEntrada >= '06:00:00' && $horaSalida > '21:00:00') {
            //aquí trabaja más de 8 horas y se pasa de las nueve.
            $va2=$valorh;
            $total=$valorh*8;
            $after = Carbon::parse('21:00:00');
            // Calcular la diferencia en extras
            $cant = $salida->diffInHours($after);
            $valorh=$valorh+($valorh*0.25);
            $msn1="Hora extra diurna";
            $total=$total+($valorh*($cantidad-8-$cant));
            $valorh=$va2+($va2*0.75);
            $msn2="Hora extra nocturna";
            $total=$total+($valorh*$cant);
        } else{
            $valorh = $valorh + ($valorh * 0.75);
            $cantidad = $cantidad + 1;
            $total = $valorh * $cantidad;
            $msn="Hora extra nocturna";
        }
    }

    if ($data) {
        $extras = new HorasExtras();
        $extras->llegada = $entrada;
        $extras->salida = $salida;
        $extras->valor = round($total, 2);
        $extras->descrip1 = $msn;
        $extras->descrip2 = $msn2;
        $extras->descrip3 = $msn3;
        $extras->users = auth()->user()->id;;

        if ($extras->save()) {
            $response["status"] = 1;
            $response["msg"] = "Datos guardados exitosamente.";
            $response["data"] = $extras;
        } else {
            $response["msg"] = "Error al guardar los datos, verificar.";
        }
    } else {
        $response["msg"] = "Error al guardar los datos, verificar.";
    }
 }else{
    $response["msg"] = "Usuario no autenticado.";
 }

    return response()->json($response);
}


    /**
     * Display the specified resource.
     */
        public function show($id)
        {

            $response = ["status" => 0, "msg" => "", "data" => ""];
            if (auth()->check()){
                $extras = HorasExtras::where("users", $id)->get();
                $response["status"] = 1;
                $response["data"] = $extras;
                $response["msg"] = "Usuario autenticado.";
            }else{
                $response["msg"] = "Usuario no autenticado.";
            }
            return response()->json($response);
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

    // Función para verificar si una fecha es festivo
    private function esFestivo($fecha)
    {
        $comprobar=false;

        $festivos = [
            '2023-01-01', // Año Nuevo
            '2023-12-25', // Navidad
        ];

        foreach ($festivos as $festivo) {
            $festivoCarbon = Carbon::parse($festivo);
                if ($festivoCarbon->isSameDay($fecha)) {
                    $comprobar = true;
                }
        }
        return $comprobar;
    }

}
