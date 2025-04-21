<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Post;

class PersonaTransformer extends TransformerAbstract
{
    #protected $availableIncludes = ['posts'];

    #protected $defaultIncludes = [];
    #protected $availableIncludes = [];

    public function transform($persona)
    {
        dd($persona);
    }

    public static function originalAttribute($index){

        $attributes =  [
            'nombres' => 'NOM_USUARIO',
            'desEst' => 'IND_ESTADO',
            'empresa' => 'COD_EMP',
            'codigo' => 'COD_USUARIO',
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;

    }
    public static function transformedAttribute($index){

        $attributes =  [
            'identificador' =>'id', 
            'name' =>'nombre', 
            'email' =>'correo', 
            'verified' =>'esVerificado', 
            'admin' =>'esAdministrador', 
            'created_at' =>'fechaCreacion', 
            'updated_at' =>'fechaModificacion', 
            'deleted_at' =>'fechaEliminacion', 
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;

    }

}
