<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Support\Facades\Auth;
//use Illuminate\Container\Attributes\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;


class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('vistaDeRutas.crear-usuario');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|max:20',
            'apellido' => 'required|max:30',
            'email' => 'required|max:60',
            'password' => [
                'required',
                'min:8',
                'max:12'
            ],
        ]);

        $user = Usuario::create($request->all());
        $user->password = Hash::make($request->password);
        $user->save();
        return redirect()->route('bienvenida');
       /* $usuario = new Usuario();
        $usuario->nombre = $request->nombre;
        $usuario->apellido = $request->apellido;
        $usuario->email = $request->email;
        $usuario->password = Hash::make($request->password);*/
    }

    /**
     * Display the specified resource.
     */
    public function show(Usuario $usuario)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Usuario $usuario)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Usuario $usuario)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Usuario $usuario)
    {
        //
    }

    public function obtenerVista()
    {
        return view('vistaDeRutas.login-usuario');
    }

    public function usuariologin(Request $request)
    {
        $credenciales = $request->validate([
            'email' => ['required','email'],
            'password' => ['required'],
        ]);

        if(Auth::attempt($credenciales)) {
            $request->session()->regenerate();

            return redirect()->intended('landing');
        } 
        else{
            return back()->withErrors([
                'email' => 'El email proporcionado es incorrecto.'
            ])->onlyInput('email');
        }

    }
}
