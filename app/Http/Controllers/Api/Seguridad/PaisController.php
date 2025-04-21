<?php

namespace App\Http\Controllers\Api\Seguridad;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\Seguridad\Models\Pais;
use App\Http\Controllers\Api\Seguridad\Resources\PaisResource;
use Illuminate\Support\Facades\DB;

class PaisController extends ApiController
{
    public function __construct()
    {
        $this->middleware('auth:api');
        $this->middleware('decrypt.claims');
    }
    public function index(Request $request)
    {
        try{
            $data = Pais::orderBy('PAIS_NOMBRE', 'ASC')
                ->where('PAIS_ESTADO', 1)
                ->get();
            return $this->successResponse(PaisResource::collection($data));
        }catch(\Exception $e){
            return $this->errorResponse('Error en el servidor', $e->getMessage(), 500);
        }
    }
    public function store(Request $request)
    {
        try {
            $pais = new Pais();
            $pais->PAIS_NOMBRE = $request->pais_nombre;
            $pais->PAIS_COD_LLAMADA = $request->pais_cod_llamada;
            $pais->PAIS_ESTADO = $request->pais_estado;
            $pais->save();
            
            return $this->successResponse(new PaisResource($pais));

        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    public function show($id)
    {
        $data = Pais::findOrFail($id);
        return response()->json($data);
    }

    public function update(Request $request)
    {
        try {
            $pais = Pais::findOrFail($request->pais_codigo);
            if (is_null($pais)) {
                return response()->json(['message' => 'data no encontrado'], 404);
            }
            $pais->PAIS_NOMBRE = $request->pais_nombre;
            $pais->PAIS_COD_LLAMADA = $request->pais_cod_llamada;
            $pais->PAIS_ESTADO = $request->pais_estado;
            $pais->save();

            return $this->successResponse(new PaisResource($pais));
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    public function destroy($id)
    {
        $data = Pais::findOrFail($id);
        if (is_null($data)) {
            return $this->errorResponse('Registro no encontrado', 404);
        }
        $data->PAIS_ESTADO = 0;
        $data->save();
        return $this->successResponse();
    }
}