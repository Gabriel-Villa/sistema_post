<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostImagenes extends Model
{
    use HasFactory;

    protected $table = 'post_imagenes';

    public $timestamps = false;
    
    protected $fillable = [
        'nombre', 
        'post_id', 
    ];


}
