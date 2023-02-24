<?php

namespace App\Http\Controllers;

use App\Models\PostImagenes;
use Illuminate\Http\Request;

class PostImagenesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PostImagenes  $postImagenes
     * @return \Illuminate\Http\Response
     */
    public function show(PostImagenes $postImagenes)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PostImagenes  $postImagenes
     * @return \Illuminate\Http\Response
     */
    public function edit(PostImagenes $postImagenes)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PostImagenes  $postImagenes
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PostImagenes $postImagenes)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PostImagenes  $postImagenes
     * @return \Illuminate\Http\Response
     */
    public function destroy(PostImagenes $postImagene)
    {
        $postImagene->delete();
    }
}
