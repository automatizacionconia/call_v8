<?php
namespace App\Http\Controllers\Api\Seguridad\Models;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Api\Seguridad\Models\Permisos;

class Perfil extends Model
{
    protected $table = 'ACCESOS.PERFIL';
    protected $primaryKey = 'PERF_CODIGO';
    public $timestamps = false;

    public function accesos()
    {
        return $this->hasMany(Permisos::class, 'PERF_CODIGO', 'PERF_CODIGO');
    }
}