<?php

namespace App\Http\Middleware;

use App\Services\EncryptionService;
use App\Traits\ApiResponser;
use Illuminate\Contracts\Encryption\DecryptException;
use Closure;

class DecryptClaims
{
    use ApiResponser;
    
    protected $exceptRoutes = [
        #'api/notificacion/insertar-bandeja',
        #'api/virtual/sgd/expediente-seguimiento/*',
        #'api/virtual/sgd/archivo/*'
    ];

    public function handle($request, Closure $next)
    {
        // if ($this->inExceptArray($request)) {
        //     return $next($request);
        // }
        try {
            #$claimsRequest = $request->header('X-claims');
            #$claims  = EncryptionService::decryptAttribute($claimsRequest, true);
            $request['empr_codigo'] = 1; #$claims['empr_codigo'];
            
        } catch (DecryptException $e) {
            return $this->errorexceptionResponse($e->getMessage());
        } 
        return $next($request);
    }

    protected function inExceptArray($request)
    {
        foreach ($this->exceptRoutes as $route) {
            if ($request->is($route)) {
                return true;
            }
        }

        return false;
    }
}
