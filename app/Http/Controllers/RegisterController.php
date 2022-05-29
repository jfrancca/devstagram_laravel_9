<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function index () 
    {
        return view('auth.register');
    }

    public function store ( Request $request ) 
    {

        // validar el request
        // $request->request->add(['username' => Str::slug( $request->username )]);

        // $this->validate($request, [
        //     'name' => 'required|max:30',
        //     'username' => 'required|unique:ursers|min:3|max:20',
        //     'email' => 'required|unique:ursers|email|max:60',
        //     'password' => 'required|confirmed:6'
        // ]);

            // Inserta datos a la tabla user
        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' =>$request->email,
            'password' => Hash::make( $request->password )
        ]);

            // Autenticar usuario
        // auth()->attempt([
        //     'email' => $request->email,
        //     'password' => $request->password
        // ]);

            //Otra forma de autenticar
        auth()->attempt($request->only('email', 'password'));

        // Redireccionar
        return redirect()->route( 'posts.index' );
    }

}
