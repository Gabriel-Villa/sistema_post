<?php

namespace App\Http\Controllers;

use App\Exports\PostExport;
use App\Http\Requests\ActualizarPostRequest;
use App\Http\Requests\CrearPostRequest;
use App\Jobs\ConvertirImagenEscalaGrisesJob;
use Illuminate\Http\Request;
use App\Models\Post;
use Excel;

class PostController extends Controller
{
   
    public function __construct()
    {
        $this->middleware('can:crear_post')->only('create');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {          
        $posts = Post::query()
            ->with('creadopor')
            ->orderBy('id', 'desc')
            ->paginate(20);
        
        return view('post.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('post.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CrearPostRequest $request)
    {
        Post::create($request->only(['nombre', 'descripcion', 'creado_por', 'fecha_creacion']));

        return redirect()->route('post.create')->with('success', 'Post creado exitosamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
       return view('post.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $this->authorize('update', $post);
        
        return view('post.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(ActualizarPostRequest $request, Post $post)
    {
        $post->update($request->only(['nombre', 'descripcion']));

        return back()->with('success', 'Post editado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->detalle()->delete();
        
        $post->delete();

        return response()->json(['mensaje' => 'Post eliminado con exito'], 200);
    }

    public function exportar_posts()
    {
        return Excel::download(new PostExport(), 'listado_posts.xlsx');
    }

}
