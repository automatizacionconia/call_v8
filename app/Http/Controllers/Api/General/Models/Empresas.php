<?php

namespace App\Http\Controllers\Api\General\Models;
use Illuminate\Database\Eloquent\Model;

class Empresas extends Model
{
    protected $table = 'GENERAL.EMPRESAS';
    protected $primaryKey = 'EMPR_CODIGO';
    public $timestamps = false;
    
}