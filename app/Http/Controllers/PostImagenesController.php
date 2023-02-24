<?php

namespace App\Http\Controllers;

use App\Models\PostImagenes;
use Illuminate\Http\Request;

class PostImagenesController extends Controller
{
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
