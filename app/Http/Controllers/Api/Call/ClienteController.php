<?php

namespace App\Http\Controllers\Api\Call;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\Call\Models\Cliente;
use App\Http\Controllers\Api\Call\Resources\ClienteResource;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use App\Http\Controllers\Api\Call\Models\ClienteGrupo;

class ClienteController extends ApiController
{
    public function __construct()
    {
        $this->middleware('auth:api')->except(['downloadTemplate']);
    }

    public function index(Request $request)
    {
        try {
            $clientes = Cliente::search($request)
            ->where('EMPR_CODIGO', auth()->user()->EMPR_CODIGO)
            ->paginate($request->per_page);
            return ClienteResource::collection($clientes);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
            $cliente = new Cliente();
            $cliente->EMPR_CODIGO = auth()->user()->EMPR_CODIGO;
            $cliente->CLIE_DOCUMENTO = $request->clie_documento;
            $cliente->CLIE_NOMBRES = Str::upper($request->clie_nombres);
            $cliente->CLIE_PATERNO = Str::upper($request->clie_paterno);
            $cliente->CLIE_MATERNO = Str::upper($request->clie_materno);
            $cliente->CLIE_CORREO = $request->clie_correo;
            $cliente->CLIE_CELULAR = $request->clie_celular;
            $cliente->CLIE_DEUDA = $request->clie_deuda;
            $cliente->CLIE_SUSCRIPTOR = $request->clie_suscriptor;
            $cliente->CLIE_CUENTA = $request->clie_cuenta;
            $cliente->CLIE_CEDULA = $request->clie_cedula;
            $cliente->CLIE_DETADEUDA = $request->clie_detadeuda;
            $cliente->CLIE_OPERADOR = auth()->user()->USUA_CODIGO;
            $cliente->CLIE_ESTACION = $_SERVER['REMOTE_ADDR'];
            $cliente->CLIE_ESTADO = $request->clie_estado;
            $cliente->save();

            return $this->successResponse();
        }catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $cliente = Cliente::findOrFail($id);
            return response()->json($cliente);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Client not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to retrieve client'], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $cliente = Cliente::findOrFail($request->clie_codigo);
            $cliente->CLIE_DOCUMENTO = $request->clie_documento;
            $cliente->CLIE_NOMBRES = $request->clie_nombres;
            $cliente->CLIE_PATERNO = $request->clie_paterno;
            $cliente->CLIE_MATERNO = $request->clie_materno;
            $cliente->CLIE_CORREO = $request->clie_correo;
            $cliente->CLIE_CELULAR = $request->clie_celular;
            $cliente->CLIE_DEUDA = $request->clie_deuda;
            $cliente->CLIE_SUSCRIPTOR = $request->clie_suscriptor;
            $cliente->CLIE_CUENTA = $request->clie_cuenta;
            $cliente->CLIE_CEDULA = $request->clie_cedula;
            $cliente->CLIE_DETADEUDA = $request->clie_detadeuda;
            $cliente->CLIE_ESTADO = $request->clie_estado;
            $cliente->save();

            return $this->successResponse();
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $cliente = Cliente::findOrFail($id);
            $cliente->CLIE_ESTADO = 0;
            $cliente->save();

            return $this->successResponse($cliente);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function cargarMasiva(Request $request)
    {
        try {
            $rules = [
                'file' => 'required|mimes:xlsx,xls,csv|max:2048',
            ];

            $messages = [
                'required'  => 'El :attribute es obligatorio',
                'mimes'     => 'El :attribute debe ser un archivo de tipo: xlsx, xls, csv.',
                'max'       => 'El :attribute no puede ser mayor que :max.',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return $this->errorexceptionResponse($validator->errors(), 422);
            }
            $file = $request->file('file');
            $data = Excel::toArray([], $file);

            if (empty($data) || count($data[0]) === 0) {
                return $this->errorexceptionResponse('El archivo está vacío.', 422);
            }
            $rows = $data[0];
            $header = array_shift($rows); // Extraer encabezados

            #FILTRAR FILAS VACÍAS
            $filteredRows = array_filter($rows, function ($row) {
                $cleanRow = array_filter($row, function ($value) {
                    return !is_null($value) && trim($value) !== '';
                });
    
                return !empty($cleanRow); #Mantener solo las filas con datos
            });

            $resultados = [];
            DB::beginTransaction();

            $grupo = new ClienteGrupo();
            $grupo->EMPR_CODIGO = auth()->user()->EMPR_CODIGO;
            $grupo->C_GRUP_NOMBRE = 'CLIENTES MASIVOS -'.date('Ymd H:i');
            $grupo->C_GRUP_OPERADOR = auth()->user()->USUA_CODIGO;
            $grupo->C_GRUP_ESTADO = 1;
            $grupo->save();
            $codigoLlamada = auth()->user()->pais->PAIS_COD_LLAMADA ?? '';
            foreach ($filteredRows as $row) {

                if (empty(Str::upper($row[1])) || empty($row[4])) {
                    continue;
                }

                $nombreCorregido = $this->limpiarTexto(Str::upper($row[1]));
                $paternoCorregido = !empty(Str::upper($row[2])) ? mb_convert_encoding(Str::upper($row[2]), 'UTF-8', 'auto') : null;
                $maternoCorregido = !empty(Str::upper($row[3])) ? mb_convert_encoding(Str::upper($row[3]), 'UTF-8', 'auto') : null;

                $cliente = new Cliente();
                $celularRaw = trim($row[5] ?? '');

                if (!empty($celularRaw)) {
                    $celularLimpio = preg_replace('/\D/', '', $celularRaw);
                    if (!Str::startsWith($celularLimpio, ltrim($codigoLlamada, '+'))) {
                        $celularLimpio = $codigoLlamada . $celularLimpio;
                    }
                    if (!Str::startsWith($celularLimpio, '+')) {
                        $celularLimpio = '+' . ltrim($celularLimpio, '+');
                    }
                    $cliente->CLIE_CELULAR = $celularLimpio;
                }

                
                $cliente->EMPR_CODIGO = auth()->user()->EMPR_CODIGO;
                $cliente->C_GRUP_CODIGO = $grupo->C_GRUP_CODIGO;
                $cliente->CLIE_DOCUMENTO = $row[0] ?? null;
                $cliente->CLIE_NOMBRES = Str::upper($nombreCorregido);
                $cliente->CLIE_PATERNO = $paternoCorregido ?? null;
                $cliente->CLIE_MATERNO = $maternoCorregido ?? null;
                #$cliente->CLIE_CORREO = $row[4] ?? null;
                $cliente->CLIE_DEUDA = $this->formatearMonto($row[4] ?? 0);
                #$cliente->CLIE_CELULAR = $row[5] ?? null;
                $cliente->CLIE_CEDULA = $row[6] ?? null;
                $cliente->CLIE_SUSCRIPTOR = $row[7] ?? null;
                $cliente->CLIE_CUENTA = $row[8] ?? null;
                $cliente->CLIE_DETADEUDA = $row[10] ?? null;
                $cliente->CLIE_OPERADOR = auth()->user()->USUA_CODIGO;
                $cliente->CLIE_ESTACION = $_SERVER['REMOTE_ADDR'];
                $cliente->CLIE_ESTADO = 1;
                $cliente->save();
                $fila = array_combine($header, $row);

                // if (isset($fila['fecha'])) {
                //     $fila['fecha'] = Date::excelToDateTimeObject($fila['fecha'])->format('Y-m-d');
                // }

                $resultados[] = $fila;
            }
            DB::commit();
            return $this->successResponse($resultados);

        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->errorexceptionResponse($th->getMessage());
        }
    }

    public function downloadTemplate()
    {
        try {
            $filePath = public_path('plantillas/CLIENTES_MASIVO.xlsx');
            return response()->download($filePath);
        } catch (\Throwable $th) {
            return $this->errorexceptionResponse($th->getMessage());
        }
    }
    private function limpiarTexto($texto)
    {
        $texto = mb_convert_encoding($texto, 'UTF-8', 'auto');
        $texto = preg_replace('/[^A-Za-zÁÉÍÓÚÑáéíóúñ ]/', '', $texto);
        $texto = trim(preg_replace('/\s+/', ' ', $texto));
        return $texto;
    }
    private function formatearMonto($monto)
    {
        $monto = trim(str_replace(['$', '€', '£', ' '], '', $monto));
        if (preg_match('/\d+,\d{2}$/', $monto)) {
            $monto = str_replace(',', '.', $monto);
        } elseif (preg_match('/\d+\.\d{2}$/', $monto)) {
        } elseif (preg_match('/\d{1,3}(\.\d{3})+,\d{2}$/', $monto)) {
            $monto = str_replace('.', '', $monto);
            $monto = str_replace(',', '.', $monto);
        } elseif (preg_match('/\d{1,3}(,\d{3})+\.\d{2}$/', $monto)) {
            $monto = str_replace(',', '', $monto);
        }
        return number_format((float) $monto, 2, '.', '');
    }
}