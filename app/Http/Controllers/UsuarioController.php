<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Support\Facades\Auth;
//use Illuminate\Container\Attributes\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\FuncCall;

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
        $validarDatos = $request->validate([
            'nombre' => 'required|max:20',
            'apellido' => 'required|max:30',
            'email' => 'required|max:60',
            'password' => [
                'required',
                'min:8',
                'max:12'
            ],
        ]);
        $validarDatos['password'] = Hash::make($validarDatos['password']);
        $usuario = Usuario::create($validarDatos);
        Auth::login($usuario);

        return redirect()->route('bienvenida');
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
        $usuario->delete();
        return redirect()->route('bienvenida');
    }

    public function obtenerVista()
    {
        return view('vistaDeRutas.login-usuario');
    }

    public function usuariologin(Request $request)
    {
        $credenciales = $request->only('email', 'password');
        $usuario = \App\Models\Usuario::where('email', $credenciales['email'])->first();

        if ($usuario && Hash::check($credenciales['password'], $usuario->password)) {
            Auth::guard('usuarios')->login($usuario);
            return redirect()->intended(route('bienvenida'));
        }
        return back()->withErrors([
            'email' => 'El email proporcionado es incorrecto.'
        ])->onlyInput('email');
    }

    public function usuariologout (Request $request)
    {
        //Auth::guard('usuarios')->logout();

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('bienvenida'); //ruta a implementar 
    }

   // public function usuariout()
    //{
     //   return redirect()->route('bienvenida');
   // }
    public function recuperarUsuario($id)
    {
        $usuario = Usuario::onlyTrashed()->find($id);
        $usuario->restore();
        return redirect()->route(''); //ruta a implementar
    }

     public function borrarUsuario($id)
    {
        $usuario = Usuario::onlyTrashed()->find($id);
        $usuario->forceDelete();
        return redirect()->route(''); //ruta a implementar
    }
    
    public function pruebaAdmin()
    {
        return view('pruebaAdmin.pruebaAdmin');
    }
}
