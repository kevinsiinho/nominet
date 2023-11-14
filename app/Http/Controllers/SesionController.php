<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class SesionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view("sesion");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $credenciales=[
            "email"=>$request->email,
            "password"=>$request->password,
        ];
        $remember=($request->has('remember')? true : false);

        if(Auth::attempt($credenciales,$remember)){
            $request->session()->regenerate();
            return redirect()->intended('home');
        }else{
            return redirect('sesion')->withErrors(['mensaje' => 'Credenciales incorrectas, inténtalo nuevamente.']);
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect(route('sesion.index'));
    }

}
