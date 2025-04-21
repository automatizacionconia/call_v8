<?php

namespace App\Http\Controllers\Api\Seguridad;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\Seguridad\Models\Empresa;
use App\Http\Controllers\Api\Seguridad\Resources\EmpresaResource;

class EmpresasController extends ApiController
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    public function index()
    {
        try{
            $data = Empresa::all();
            return $this->successResponse(EmpresaResource::collection($data));

        }catch(\Exception $e){
            return $this->errorResponse('Error en el servidor', $e->getMessage(), 500);
        }
    }

    public function show($id)
    {
        $empresa = Empresa::find($id);

        if (!$empresa) {
            return response()->json(['message' => 'Empresa no encontrada'], 404);
        }

        return response()->json(['data' => $empresa], 200);
    }

    public function store(Request $request)
    {
        try{
            $empresa = new Empresa();
            $empresa->EMPR_NOMBRE = $request->empr_nombre;
            $empresa->EMPR_ABREV = $request->empr_abrev;
            $empresa->EMPR_DIRECCION = $request->empr_direccion;
            $empresa->EMPR_RUC = $request->empr_ruc;
            $empresa->EMPR_ESTADO = $request->empr_estado;
            $empresa->save();

        }catch(\Exception $e){
            return $this->errorResponse('Error en el servidor', $e->getMessage(), 500);
        }
        return $this->successResponse('Empresa creada exitosamente', 201);
    }

    public function update(Request $request, $id)
    {
        $empresa = Empresa::find($request->empr_codigo);

        if (!$empresa) {
            return $this->exceptionResponse('Empresa no encontrada');
        }

        $empresa->EMPR_NOMBRE = $request->empr_nombre;
        $empresa->EMPR_ABREV = $request->empr_abrev;
        $empresa->EMPR_DIRECCION = $request->empr_direccion;
        $empresa->EMPR_RUC = $request->empr_ruc;
        $empresa->EMPR_ESTADO = $request->empr_estado;
        $empresa->save();

        return $this->successResponse('Empresa actualizada exitosamente', 200);
    }

    public function destroy($id)
    {
        $empresa = Empresa::find($id);

        if (!$empresa) {
            return $this->exceptionResponse('Empresa no encontrada');
        }
        $empresa->EMPR_ESTADO = 0;
        $empresa->save();

        return $this->successResponse('Empresa actualizada exitosamente', 200);
    }
}