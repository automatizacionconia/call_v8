<?php

namespace App\Http\Controllers\Api\Seguridad\Models;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Api\General\Models\Empresas;

class UsuaEmpresas extends Model
{
    protected $table = 'ACCESOS.USUA_EMPRESAS';
    protected $primaryKey = 'UEMP_CODIGO';
    public $timestamps = false;

    public static $keys = ['UEMP_CODIGO', 'EMPR_CODIGO'];
    
    public function empresa()
    {
        return $this->belongsTo(Empresas::class, 'EMPR_CODIGO', 'EMPR_CODIGO');
    }
}