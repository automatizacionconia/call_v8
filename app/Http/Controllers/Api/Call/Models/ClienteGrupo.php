<?php

namespace App\Http\Controllers\Api\Call\Models;
use Illuminate\Database\Eloquent\Model;

class ClienteGrupo extends Model
{
    protected $table = 'CALLCENTER.CLIENTES_GRUPO';
    protected $primaryKey = 'C_GRUP_CODIGO';
    public $timestamps = false;
}