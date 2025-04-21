<?php
namespace App\Http\Controllers\Api\Call;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\Call\Models\Agente;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\Call\Resources\AgenteResource;
use Illuminate\Support\Str;

class AgenteController extends ApiController
{
    public function index(Request $request)
    {
        try {
            $agentes = Agente::search($request)->paginate($request->per_page);
            return AgenteResource::collection($agentes);

        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'agen_nombre' => 'required|string|max:255',
            'plat_codigo' => 'required',
        ]);

        try {
            $agente = new Agente();
            $agente->AGEN_NOMBRE = Str::upper($request->agen_nombre);
            $agente->PLAT_CODIGO = $request->plat_codigo;
            $agente->AGEN_API = $request->agen_api;
            $agente->AGEN_KEY = $request->agen_key;
            $agente->AGEN_PASS = $request->agen_pass;
            $agente->AGEN_ESTADO = $request->agen_estado;
            $agente->save();


            return $this->successResponse($agente);

        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    public function show($id)
    {
        $agente = Agente::findOrFail($id);
        return response()->json($agente);
    }

    public function update(Request $request, $id)
    {
        try {
            $agente = Agente::findOrFail($request->agen_codigo);
            $agente->AGEN_NOMBRE = Str::upper($request->agen_nombre);
            $agente->PLAT_CODIGO = $request->plat_codigo;
            $agente->AGEN_API = $request->agen_api;
            $agente->AGEN_KEY = $request->agen_key;
            $agente->AGEN_PASS = $request->agen_pass;
            $agente->AGEN_ESTADO = $request->agen_estado;
            $agente->save();

            return $this->successResponse();

        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $agente = Agente::findOrFail($id);
            $agente->AGEN_ESTADO = 0;
            $agente->save();

            return $this->successResponse();

        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }
}