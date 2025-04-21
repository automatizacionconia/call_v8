<?php

namespace App\Http\Controllers\Api\Seguridad\Models;
use Illuminate\Database\Eloquent\Model;

class Pais extends Model
{
    protected $table = 'GENERAL.PAIS';
    protected $primaryKey = 'PAIS_CODIGO';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'PAIS_NOMBRE',
        'PAIS_COD_LLAMADA',
        'PAIS_ESTADO',
    ];

    // Default attributes
    protected $attributes = [
        'PAIS_ESTADO' => 1,
    ];
}