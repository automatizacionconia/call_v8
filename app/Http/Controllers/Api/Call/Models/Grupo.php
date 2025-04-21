<?php
namespace App\Http\Controllers\Api\Call\Models;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Api\Call\Models\Programacion;

class Grupo extends Model
{
    protected $table = 'CALLCENTER.GRUPO';
    protected $primaryKey = 'GRUP_CODIGO';
    public $timestamps = false;

    protected $fillable = [
        'EMPR_CODIGO',
        'GRUP_NOMBRE',
        'GRUP_OPERADOR',
        'GRUP_ESTADO'
    ];

    public function programaciones()
    {
        return $this->hasMany(Programacion::class, 'GRUP_CODIGO', 'GRUP_CODIGO');
    }
}