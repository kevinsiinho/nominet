<?php

namespace App\Http\Controllers;
use App\Models\TipoID;
use App\Models\User;
use App\Models\HorasExtras;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;


class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $id=null;
        if (Auth::check()) {
            // Si el usuario está autenticado, pasar el nombre a la vista
            $usuario = Auth::user();
            $id = $usuario->id;

        }
        $resultado = DB::table('model_has_roles')->where('model_id', $id)->first();
        $roluser = $resultado ? (int) $resultado->role_id : null;

        if($roluser==3){
            return redirect('home/' . $id . '/edit');
        }else{
            return view('home',['tipoids'=>TipoID::all(),'users'=>User::all()]);
        }

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $tipoform = $request->input('form');
        if ($tipoform === 'form1') {
            $request->validate([
                'tipoid'=>'required',
                'id'=>'required|unique:users,id',
                'name'=>'required',
                'lastname'=>'required',
                'email'=>'required|unique:users,email',
                'salario'=>'required',
                'cargo'=>'required',
            ]);

            $nuevo=new User();
            $nuevo->tipoid=$request->input('tipoid');
            $nuevo->id=$request->input('id');
            $nuevo->password=$request->input('id');
            $nuevo->name=$request->input('name');
            $nuevo->lastname=$request->input('lastname');
            $nuevo->email=$request->input('email');
            $nuevo->salario=$request->input('salario');
            $nuevo->cargo=$request->input('cargo');
            $nuevo->save();
        } elseif ($tipoform === 'form2') {
            $request->validate([
                'name'=>'required'
            ]);
            $tipo =new TipoID();
            $tipo->name=$request->input('name');
            $tipo->save();

        }
        return view('home',['tipoids'=>TipoID::all()],['users'=>User::all()]);
    }

    public function edit($id)
    {
        $horas= HorasExtras::where('users', $id)->get();
        $totalh=null;
        $totalp=null;
        $roluser=null;
        foreach($horas as $hora){
            $totalh=$hora->cantidad+$totalh;
        }
        $user =User::find($id);
        $totalp=($totalh*7000)+$user->salario;
        $roles=Role::all();
        $resultado = DB::table('model_has_roles')->where('model_id', $id)->first();
        $roluser = $resultado ? (int) $resultado->role_id : null;

        return view('editar',['tipoids'=>TipoID::all(),'user'=>$user,'horas'=>$horas, 'totalh'=>$totalh,'totalp'=>$totalp,'roles'=>$roles,'roluser'=>$roluser]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $tipoform = $request->input('form');
        $cantidad=null;
        $id =(int)$id;
        if ($tipoform === 'form3') {
            $request->validate([
                'tipoid'=>'required',
                'name'=>'required',
                'lastname'=>'required',
                'email' => 'required|unique:users,email,' . $id,
                'cargo'=>'required',
            ]);

            $nuevo=User::find($id);
            $nuevo->tipoid=$request->input('tipoid');
            $nuevo->name=$request->input('name');
            $nuevo->lastname=$request->input('lastname');
            $nuevo->email=$request->input('email');
            $nuevo->cargo=$request->input('cargo');
            $nuevo->save();
            $rol=$request->input('rol');
            $nuevo->roles()->sync($rol);

            $horas = new HorasExtras();
            $entrada = Carbon::parse($request->input('llegada'));
            $salida = Carbon::parse($request->input('salida'));
            $cantidad = $entrada->diff($salida)->h;
            $horas->llegada=$entrada;
            $horas->salida=$salida;
            $horas->users=$id;
            if($cantidad==null){

            }elseif($cantidad<9){
                $cantidad=0;
                $horas->cantidad=$cantidad;
                $horas->save();
            }elseif($cantidad>8){
             $cantidad=$cantidad-8;
             $horas->cantidad=$cantidad;
             $horas->save();
            }
        }else{
            $request->validate([
                'name'=>'required'
            ]);
            $tipo =TipoID::find($id);
            $tipo->name=$request->input('name');
            $tipo->save();
        }
        return view('home',['tipoids'=>TipoID::all()],['users'=>User::all()]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request,$id)
    {
        $id =(int)$id;
        $tipoform = $request->input('form');

        if($tipoform==="form4"){
            $user=User::find($id);
            $user->delete();

        }elseif($tipoform==="form5"){

            $tipo =TipoID::find($id);
            $tipo->delete();
        }

        return redirect()->route('home.index')->with(['tipoids' => TipoID::all(), 'users' => User::all()]);
    }
}
