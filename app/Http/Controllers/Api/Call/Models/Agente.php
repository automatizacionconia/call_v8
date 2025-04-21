<?php

namespace App\Http\Controllers\Api\Call\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Api\Call\Models\Plataforma;
use App\Http\Controllers\Api\Call\Models\Cartera;

class Agente extends Model
{
    protected $table = 'CALLCENTER.AGENTES';
    protected $primaryKey = 'AGEN_CODIGO';
    public $timestamps = false;

    protected $fillable = [
        'EMPR_CODIGO',
        'AGEN_NOMBRE',
        'PLAT_CODIGO',
        'AGEN_API',
        'AGENT_KEY',
        'AGENT_PASS',
        'AGENT_OPERADOR',
        'AGENT_ESTACION',
        'AGENT_FECHING',
        'AGENT_ESTADO'
    ];

    protected $casts = [
        'AGENT_FECHING' => 'datetime',
    ];

    public function scopeSearch($query, $request)
    {
        if ($request->has('dato'))
            $query->where('AGEN_NOMBRE', 'ilike', '%' . $request->dato . '%')
                ->orWhere('PLAT_CODIGO', 'ilike', '%' . $request->dato . '%');

        return $query;
    }

    public function plataforma()
    {
        return $this->belongsTo(Plataforma::class, 'PLAT_CODIGO', 'PLAT_CODIGO');
    }

    //TOTAL CARTERA ASIGNADA AL AGENTE
    public function totalCartera()
    {
        return Cartera::where('AGEN_CODIGO', $this->AGEN_CODIGO)
            ->where('CART_ESTADO', 1)
            ->count();
    }
    public function cartera()
    {
        return $this->hasMany(Cartera::class, 'AGEN_CODIGO', 'AGEN_CODIGO');
    }
    
}