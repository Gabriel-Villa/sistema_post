<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory;

    const POST_NO_PUBLICADO = 0;
    const POST_PUBLICADO = 1;

    protected $table = 'posts';

    public $timestamps = false;
    
    protected $dates = ['fecha_creacion'];

    protected $fillable = [
        'nombre', 
        'slug', 
        'descripcion',
        'fecha_creacion',
        'publicado',
        'creado_por',
    ];

    private static $estadosPost = [
        self::POST_NO_PUBLICADO => 'Sin publicar',
        self::POST_PUBLICADO => 'Publicado',
    ];

    // Relaciones
    public function creadopor()
    {
        return $this->hasOne(User::class, 'id', 'creado_por');
    }

    public function detalle()
    {
        return $this->hasMany(PostImagenes::class, 'post_id', 'id');
    }

    public function permiso()
    {
        return $this->hasMany(PermisosEdicionPost::class, 'post_id', 'id');
    }

    // Mutaciones
    public function setNombreAttribute($value)
    {
        $this->attributes['nombre'] = ucwords(trim($value));
        $this->attributes['slug'] = Str::slug($value, '-');
    }

    public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = Str::slug($value, '-');
    }

    public function setDescripcionAttribute($value)
    {
        $this->attributes['descripcion'] = trim($value);
    }

    // Accesors
    public function getNombreAttribute($value)
    {
        return Str::headline($value);
    }

    public function getDescripcionAttribute($value)
    {
        return Str::limit($value, 20, ' (...)');
    }

    public function getEstadoPostAttribute($value)
    {
        return self::$estadosPost[$this->publicado] ?? '';
    }

}
