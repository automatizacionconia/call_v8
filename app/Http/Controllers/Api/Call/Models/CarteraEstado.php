<?php
namespace App\Http\Controllers\Api\Call\Models;
use Illuminate\Database\Eloquent\Model;
class CarteraEstado extends Model
{
    protected $table = 'CALLCENTER.CARTERA_ESTADO';
    protected $primaryKey = 'C_ESTA_CODIGO';
    public $timestamps = false;
}