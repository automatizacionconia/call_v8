<?php

namespace App\Http\Controllers\Api\Seguridad;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\Seguridad\Models\Perfil;
use App\Http\Controllers\Api\Seguridad\Models\Permisos;
use App\Http\Controllers\Api\Seguridad\Resources\AccesoPerfilResource;
use App\Http\Controllers\Api\Seguridad\Resources\PerfilResource;
use Illuminate\Support\Facades\DB;

class PerfilController extends ApiController
{
    public function __construct()
    {
        $this->middleware('auth:api');
        $this->middleware('decrypt.claims');
    }
    public function index(Request $request)
    {
        try{
            $perfiles = Perfil::where('EMPR_CODIGO', $request->empr_codigo)->get();
            return $this->successResponse(PerfilResource::collection($perfiles));
        }catch(\Exception $e){
            return $this->errorResponse('Error en el servidor', $e->getMessage(), 500);
        }
    }
    public function store(Request $request)
    {
        try {
            $perfil = new Perfil();
            $perfil->PERF_NOMBRE = $request->perf_nombre;
            $perfil->PERF_NC_NOMBRE = $request->perf_nc_nombre;
            $perfil->PERF_ESTADO = $request->perf_estado;
            $perfil->EMPR_CODIGO = $request->empr_codigo;
            $perfil->save();
            
            return $this->successResponse(new PerfilResource($perfil));

        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    public function show($id)
    {
        $perfil = Perfil::findOrFail($id);
        return response()->json($perfil);
    }

    public function update(Request $request)
    {
        try {
            $perfil = Perfil::findOrFail($request->perf_codigo);
            if (is_null($perfil)) {
                return response()->json(['message' => 'Perfil no encontrado'], 404);
            }
            $perfil->PERF_NOMBRE = $request->perf_nombre;
            $perfil->PERF_NC_NOMBRE = $request->perf_nc_nombre;
            $perfil->PERF_ESTADO = $request->perf_estado;
            $perfil->save();

            return $this->successResponse(new PerfilResource($perfil));
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    public function destroy($id)
    {
        $perfil = Perfil::findOrFail($id);
        if (is_null($perfil)) {
            return $this->errorResponse('Perfil no encontrado', 404);
        }
        $perfil->PERF_ESTADO = 0;
        $perfil->save();
        return $this->successResponse();
    }
    public function accesosPerfil($id)
    {
        try {
            $perfil = Perfil::findOrFail($id);
        if (is_null($perfil)) {
            return $this->errorResponse('Perfil no encontrado', 404);
        }
        return $this->successResponse(AccesoPerfilResource::collection($perfil->accesos));
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }
    public function storePerfil(Request $request)
    {
        try {
            Permisos::where('PERF_CODIGO', $request->perf_codigo)->delete();
            $accesosArray = $request->accesos;
            $insertedIds = [];

            DB::transaction(function () use ($accesosArray, $request, &$insertedIds) {
                foreach ($accesosArray as $acceso) {
                    $nuevoAcceso = Permisos::create([
                        'OPCI_CODIGO' => $acceso,
                        'PERF_CODIGO' => $request->perf_codigo,
                        'PERM_ESTADO' => 1,
                    ]);

                    $insertedIds[] = $nuevoAcceso->ACCE_CODIGO;
                }
            });
        } catch (\Throwable $th) {
            return $this->exceptionResponse($th->getMessage());
        }

        return $this->successResponse('Accesos asignados correctamente');
    }
}