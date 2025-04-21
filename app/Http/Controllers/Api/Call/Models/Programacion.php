<?php

namespace App\Http\Controllers\Api\Call\Models;
use Illuminate\Database\Eloquent\Model;

class Programacion extends Model
{
    protected $table = 'CALLCENTER.PROGRAMACION';
    protected $primaryKey = 'PROG_CODIGO';
    public $timestamps = false;

    protected $fillable = [
        'PROG_DIA',
        'PROG_HORA',
        'CART_CODIGO',
        'PROG_ESTADO'
    ];
}