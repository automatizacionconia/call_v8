<?php

namespace App\Http\Controllers\Api\General\Models;
use Illuminate\Database\Eloquent\Model;

class Sedes extends Model
{
    protected $table = 'GENERAL.SEDES';
    protected $primaryKey = 'SEDE_CODIGO';
    public $timestamps = false;
}