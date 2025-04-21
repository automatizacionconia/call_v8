<?php

namespace App\Http\Controllers\Api\Call\Models;
use Illuminate\Database\Eloquent\Model;

class Plataforma extends Model
{
    protected $table = 'CALLCENTER.PLATAFORMA';
    protected $primaryKey = 'PLAT_CODIGO';
    public $timestamps = false;

    protected $fillable = [
        'EMPR_CODIGO',
        'PLAT_NOMBRE',
        'PLAT_URL',
        'PLAT_ESTADO'
    ];

    protected $casts = [
        'PLAT_FECHING' => 'datetime',
    ];

    public function scopeSearch($query, $request)
    {
        if ($request->has('dato'))
            $query->where('PLAT_NOMBRE', 'ilike', '%' . $request->dato . '%')
                ->orWhere('PLAT_URL', 'ilike', '%' . $request->dato . '%');
        

        return $query;
    }
}