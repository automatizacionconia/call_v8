<?php
namespace App\Http\Controllers\Api\Call\Models;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Api\Call\Models\Agente;
use App\Http\Controllers\Api\Call\Models\Cliente;
use App\Http\Controllers\Api\Call\Models\Grupo;
use App\Http\Controllers\Api\Call\Models\CarteraEstado;
class Cartera extends Model
{
    protected $table = 'CALLCENTER.CARTERA';
    protected $primaryKey = 'CART_CODIGO';
    public $timestamps = false;

    protected $fillable = [
        'EMPR_CODIGO',
        'AGEN_CODIGO',
        'CLIE_CODIGO',
        'CART_FECHENVIO',
        'CART_FECHING',
        'CART_OPERADOR',
        'CART_ESTADO'
    ];

    public function scopeSearch($query, $request)
    {
        if ($request->has('grup_codigo'))
            $query->where('GRUP_CODIGO', $request->grup_codigo);

        return $query;
        
        if ($request->has('cliente')) {
            $query->where('CLIE_CODIGO', $request->cliente);
        }
    }
    public function agente()
    {
        return $this->belongsTo(Agente::class, 'AGEN_CODIGO', 'AGEN_CODIGO');
    }
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'CLIE_CODIGO', 'CLIE_CODIGO');
    }
    public function grupo()
    {
        return $this->belongsTo(Grupo::class, 'GRUP_CODIGO', 'GRUP_CODIGO');
    }
    public function estado()
    {
        return $this->belongsTo(CarteraEstado::class, 'C_ESTA_CODIGO', 'C_ESTA_CODIGO');
    }
}