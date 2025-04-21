<?php

namespace App\Http\Controllers\Api\Seguridad\Models;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Api\Seguridad\Models\Opciones;

class Permisos extends Model
{
    protected $table = 'ACCESOS.PERMISOS';
    protected $primaryKey = 'PERM_CODIGO';
    public $timestamps = false;

    protected $fillable = [
        'PERM_CODIGO',
        'PERF_CODIGO',
        'OPCI_CODIGO',
        'PERM_ESTADO'
    ];

    public function opciones()
    {
        return $this->belongsTo(Opciones::class, 'OPCI_CODIGO', 'OPCI_CODIGO');
    }
}