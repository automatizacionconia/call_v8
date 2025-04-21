<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Validation\ValidationException;

class TransformInput
{
    public function handle($request, Closure $next, $transformer)
    {   
        $tranformerInput = [];

        /*foreach($request->request->all() as $input){
            $tranformerInput[$transformer::originalAttribute($input['propiedad_value'])]=$input['propiedad_value'];
        }  */ 
        foreach($request->request->all() as $input => $value){
            $tranformerInput[$transformer::originalAttribute($input)]=$value;
        }
        
        $request->replace($tranformerInput);

        $response = $next($request);
        
        if(isset($response->exception) && $response->exception instanceof ValidationException){
            
            $data = $response->getData();

            $transformedErrors = [];

            foreach($data->error as $field => $error){
                $tranformedFiled = $transformer::transformedAttribute($field);
                $transformedErrors[$tranformedFiled] = str_replace($field,$tranformedFiled,$error);
            }

            $data->error = $transformedErrors;

            $response->setData($data);
        }
        return $response;
    }
}