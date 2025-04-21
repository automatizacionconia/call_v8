<?php
namespace App\Http\Controllers\Api\Seguridad\Models;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    protected $table = 'GENERAL.EMPRESAS';
    protected $primaryKey = 'EMPR_CODIGO';
    public $timestamps = false;
    protected $fillable = [
        'EMPR_NOMBRE',
        'EMPR_ABREV',
        'EMPR_DIRECCION',
        'EMPR_CONTACTOS',
        'EMPR_LOGO',
        'EMPR_ESTADO',
        'EMPR_RUC',
    ];
}