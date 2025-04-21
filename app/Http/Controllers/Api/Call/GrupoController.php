<?php

namespace App\Http\Controllers\Api\Call;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\Call\Models\Grupo;
use App\Http\Controllers\Api\Call\Resources\GrupoResource;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;


class GrupoController extends ApiController
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    public function index()
    {
        try {
            $grupos = Grupo::where('EMPR_CODIGO', auth()->user()->EMPR_CODIGO)
                ->where('GRUP_ESTADO', 1)
                ->orderBy('GRUP_CODIGO', 'DESC')
                ->get(['GRUP_CODIGO', 'GRUP_NOMBRE','GRUP_ESTADO']);

            return GrupoResource::collection($grupos)->additional([
                'meta' => [
                    'status' => 200,
                    'message' => 'Success',
                ],
            ]);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
        
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $grupo = Grupo::findOrFail($id);
            return response()->json($grupo, 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'sometimes|required|string|max:255',
            ]);

            $grupo = Grupo::findOrFail($id);
            $grupo->update($validatedData);
            return response()->json($grupo, 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $grupo = Grupo::findOrFail($id);
            $grupo->delete();
            return response()->json(['message' => 'Group deleted successfully'], 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }
}