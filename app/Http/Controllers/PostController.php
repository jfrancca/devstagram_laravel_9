<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('show', 'index');
    }
    
    public function index( User $user ) 
    {
        // dd($user->username);
        $posts = Post::where('user_id', $user->id)->paginate(4);

        return view('dashboard', [
            'user' => $user,
            'posts' => $posts
        ]);
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store( Request $request )
    {
        $this->validate($request, [
            'titulo' => 'required|max:255',
            'descripcion' => 'required',
            'imagen' => 'required'
        ]);

        // Post::create([
        //    'titulo' => $request->titulo,
        //    'descripcion' => $request->descripcion, 
        //    'imagen' => $request->imagen, 
        //    'user_id' => auth()->user()->id // crear en la tabla el id del usuario registrado
        // ]);

            // otra forma de insertar datos en la tabla
        // $post = new Post;
        // $post->titulo = $request->titulo;
        // $post->descripcion = $request->descripcion;
        // $post->imagen = $request->imagen;
        // $post->user_id = auth()->user()->id;
        // $post->save();

            // otra forma de insertar, utilizando la relación creada
        $request->user()->posts()->create([
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion, 
            'imagen' => $request->imagen, 
            'user_id' => auth()->user()->id // crear en la tabla el id del usuario registrado
        ]);

        return redirect()->route('posts.index', auth()->user()->username);
    }

    public function show(User $user, Post $post)
    {
        return view('posts.show', [
            'post' => $post, 
            'user' => $user
        ]);
    }
}
