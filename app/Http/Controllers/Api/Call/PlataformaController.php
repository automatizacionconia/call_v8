<?php
namespace App\Http\Controllers\Api\Call;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\Call\Models\Plataforma;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\Call\Resources\PlataformaResource;
use Illuminate\Support\Str;

class PlataformaController extends ApiController
{
    public function index(Request $request)
    {
        try {
            $respose = Plataforma::search($request)->paginate($request->per_page);
            return PlataformaResource::collection($respose);

        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'plat_nombre' => 'required|string|max:255',
            'plat_url' => 'required|string',
        ]);

        try {
            $table = new Plataforma();
            $table->PLAT_NOMBRE = Str::upper($request->plat_nombre);
            $table->PLAT_URL = Str::upper($request->plat_url);
            $table->PLAT_ESTADO = $request->plat_estado;
            $table->save();

            return $this->successResponse($table);

        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    public function show($id)
    {
        $table = Plataforma::findOrFail($id);
        return response()->json($table);
    }

    public function update(Request $request, $id)
    {
        try {
            $table = Plataforma::findOrFail($request->plat_codigo);
            $table->PLAT_NOMBRE = Str::upper($request->plat_nombre);
            $table->PLAT_URL = Str::upper($request->plat_url);
            $table->PLAT_ESTADO = $request->plat_estado;
            $table->save();

            return $this->successResponse();

        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $table = Plataforma::findOrFail($id);
            $table->PLAT_ESTADO = 0;
            $table->save();

            return $this->successResponse();

        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }
}