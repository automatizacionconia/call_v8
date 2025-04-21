<?php

namespace App\Http\Controllers\Api\Call\Models;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'CALLCENTER.CLIENTES';
    protected $primaryKey = 'CLIE_CODIGO';
    public $timestamps = false;

    protected $fillable = [
        'EMPR_CODIGO',
        'CLIE_DOCUMENTO',
        'CLIE_NOMBRES',
        'CLIE_PATERNO',
        'CLIE_MATERNO',
        'CLIE_CORREO',
        'CLIE_CELULAR',
        'CLIE_DEUDA',
        'CLIE_SUSCRIPTOR',
        'CLIE_CUENTA',
        'CLIE_CEDULA',
        'CLIE_DETADEUDA',
        'CLIE_FECHING',
        'CLIE_OPERADOR',
        'CLIE_ESTACION',
        'CLIE_ESTADO'
    ];

    protected $casts = [
        'CLIE_FECHING' => 'datetime',
    ];

    public function scopeSearch($query, $request)
    {
        if ($request->has('dato'))
            $query->where('CLIE_DOCUMENTO', 'ilike', '%' . $request->dato . '%')
                ->orWhere('CLIE_NOMBRES', 'ilike', '%' . $request->dato . '%')
                ->orWhere('CLIE_PATERNO', 'ilike', '%' . $request->dato . '%')
                ->orWhere('CLIE_MATERNO', 'ilike', '%' . $request->dato . '%')
                ->orWhere('CLIE_CORREO', 'ilike', '%' . $request->dato . '%')
                ->orWhere('CLIE_CELULAR', 'ilike', '%' . $request->dato . '%')
                ->orWhere('CLIE_DEUDA', 'ilike', '%' . $request->dato . '%')
                ->orWhere('CLIE_DETADEUDA', 'ilike', '%' . $request->dato . '%');
        

        return $query;
    }
}