<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermisosEdicionPost extends Model
{
    use HasFactory;

    const ESTADO_PENDIENTE = 0;
    const ESTADO_APROBADO = 1;
    const ESTADO_RECHAZADO = 2;
    const ESTADO_FINALIZADO = 3;
    const ESTADO_EN_CURSO = 4;

    protected $table = 'permisos_edicion_post';

    public $timestamps = false;

    protected $fillable = [
        'post_id',
        'solicitado_por',
        'estado',
        'token',
    ];

    // Relaciones
    public function post()
    {
        return $this->hasOne(Post::class, 'id', 'post_id');
    }

    public function solicitadopor()
    {
        return $this->hasOne(User::class, 'id', 'solicitado_por');
    }

    // Scopes
    public static function scopebypost($query, $post_id)
    {
        return $query->where('post_id', $post_id);
    }

    public static function scopebysolicitadopor($query, $usuario_id)
    {
        return $query->where('solicitado_por', $usuario_id);
    }

    public static function scopebytoken($query, $token)
    {
        return $query->where('token', $token);
    }

    public static function scopependientes($query)
    {
        return $query->where('estado', self::ESTADO_PENDIENTE);
    }

    public static function scopeaprobado($query)
    {
        return $query->where('estado', self::ESTADO_APROBADO);
    }

    public static function scopeencurso($query)
    {
        return $query->where('estado', self::ESTADO_EN_CURSO);
    }

    // Accesors
    public function esta_aprobado()
    {
        return $this->estado == Self::ESTADO_APROBADO;
    }

    public function esta_en_curso()
    {
        return $this->estado == Self::ESTADO_EN_CURSO;
    }

    public function getEstadoRechazadoAttribute($value)
    {
        return Self::ESTADO_RECHAZADO;
    }

    public function getEstadoAprobadoAttribute($value)
    {
        return Self::ESTADO_APROBADO;
    }

    public function getEstadoEnCursoAttribute($value)
    {
        return Self::ESTADO_EN_CURSO;
    }

}
