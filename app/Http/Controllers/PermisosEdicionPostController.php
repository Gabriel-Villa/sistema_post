<?php

namespace App\Http\Controllers;

use App\Http\Requests\PermisosEdicionPostRequest;
use App\Models\PermisosEdicionPost;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Log;

class PermisosEdicionPostController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:solicitudes.index')->only('index');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $solicitudes = PermisosEdicionPost::with(['post', 'solicitadopor'])->pendientes()->get();

        return view('post.permisos', compact('solicitudes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        PermisosEdicionPost::create($request->only('post_id') + ['solicitado_por' => auth()->id()]);
        
        return response()->json(['mensaje' => 'Se solicitaron los permisos con exito'], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PermisosEdicionPost  $permisos_post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PermisosEdicionPost $permisos_post)
    {
        $permisos_post->update(['estado' => $request->estado, 'token' => (string) Str::uuid()]);

        return response()->json(['mensaje' => 'Solicitud procesada con exito'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PermisosEdicionPost  $permisos_post
     * @return \Illuminate\Http\Response
     */
    public function destroy(PermisosEdicionPost $permisos_post)
    {
        //
    }

    public function verificar_token($token)
    {
        PermisosEdicionPost::query()
            ->bytoken($token)
            ->bysolicitadopor(auth()->id())
            ->aprobado()
            ->firstOrFail();

        return view('post.token');
    }

    public function comparar_token(PermisosEdicionPostRequest $request)
    {
        $existe_token = PermisosEdicionPost::query()
            ->bytoken($request->token)
            ->bysolicitadopor(auth()->id())
            ->aprobado()
            ->firstOrFail();

        $existe_token->update(['estado' => PermisosEdicionPost::ESTADO_EN_CURSO]);

        return redirect()->route('post.index')->with('success', 'Permiso concedido por .' . config('helpers.tiempo_edicion_minutos'));
    }

}
