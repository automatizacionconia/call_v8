<?php
namespace App\Http\Controllers\Api\General\Models;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Api\Seguridad\Models\Usuarios;

class Persona extends Model
{
    protected $table = 'GENERAL.PERSONA';
    protected $primaryKey = 'PERS_CODIGO';
    public $timestamps = false;

    public function usuario()
    {
        return $this->hasOne(Usuarios::class, 'PERS_CODIGO', 'PERS_CODIGO');
    }
}