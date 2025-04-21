<?php

namespace App\Http\Controllers\Api\Call;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\Call\Models\Cliente;
use App\Http\Controllers\Api\Call\Models\Agente;
use App\Http\Controllers\Api\Call\Models\Call;
use App\Http\Controllers\Api\Call\Models\Cartera;
use App\Http\Controllers\Api\Call\Models\Grupo;
use App\Http\Controllers\Api\Call\Models\Programacion;
use App\Http\Controllers\Api\Call\Resources\AgentesCarteraResource;
use App\Http\Controllers\Api\Call\Resources\CallResource;
use App\Http\Controllers\Api\Call\Resources\CarteraResource;
use App\Http\Controllers\Api\Call\Resources\ClientesCarteraResource;
use App\Http\Controllers\ApiController;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Api\Call\Exports\CarteraExport;

class CarteraController extends ApiController
{
    public function __construct()
    {
        $this->middleware('auth:api')->except(['exportExcel']);
    }

    public function clientes(Request $request)
    {
        try {
            $clientes = Cliente::search($request)
            ->where('EMPR_CODIGO', auth()->user()->EMPR_CODIGO)
            ->orderBy('CLIE_CODIGO', 'desc')
            ->get();
            return ClientesCarteraResource::collection($clientes);

        } catch (\Throwable $th) {
            return $this->errorexceptionResponse($th->getMessage());
        }
    }

    public function agentes(Request $request)
    {
        try {
            $response = Agente::search($request)
            ->orderBy('AGEN_NOMBRE')
            ->with('plataforma')
            ->get();
            
            return AgentesCarteraResource::collection($response);

        } catch (\Throwable $th) {
            return $this->errorexceptionResponse($th->getMessage());
        }
    }
    public function carteraGrupo(Request $request)
    {
        try {

            $response = Cartera::search($request)
            ->where('GRUP_CODIGO', $request->grup_codigo)
            ->orderBy('CART_CODIGO', 'desc')
            ->with('cliente')
            ->with('agente')
            ->get();
        
            return CarteraResource::collection($response);

        } catch (\Throwable $th) {
            return $this->errorexceptionResponse($th->getMessage());
        }
    }
    public function llamadasTelefono($id, Request $request)
    {
        try {
            $cartera = Cartera::where('CART_CODIGO', $request->cart_codigo)
            ->first();

            $fechaEnvio = Carbon::parse($cartera->CART_FECHENVIO)->format('Y-m-d H:i');

            $response = Call::where('to_number', $request->clie_celular)
            ->whereRaw("TO_CHAR(date_start_format, 'YYYY-MM-DD HH24:MI') = ?", [$fechaEnvio])
            ->get();
        
            return CallResource::collection($response);

        } catch (\Throwable $th) {
            return $this->errorexceptionResponse($th->getMessage());
        }
    }
    public function store(Request $request)
    {
        try {
            $data = $request->json()->all();
            $rules = [
                'agente' => 'required|integer',
                'clientes' => 'required|array|min:1',
                'grupo' => 'required|string|max:100',
                'dias' => 'required|array|min:1',
            ];

            $messages = [
                'required'  => 'El :attribute es obligatorio',
                'string'    => 'El :attribute debe tener formato de texto',
                'max'       => 'El :attribute no puede ser mayor que :max.',
                'integer'   => 'El :attribute debe ser entero',
            ];

            $validator = Validator::make($data, $rules, $messages);

            if ($validator->fails()) {
                return $this->errorexceptionResponse($validator->errors(), 422);
            }

            $agente = $request->agente;
            $cliente = $request->clientes;
            $horario_dias = $request->dias;
            $horario_horas = $request->horas;

            DB::beginTransaction();
            $grupo = new Grupo();
            $grupo->EMPR_CODIGO = auth()->user()->EMPR_CODIGO;
            $grupo->GRUP_NOMBRE = $request->grupo;
            $grupo->GRUP_OPERADOR = auth()->user()->USUA_CODIGO;
            $grupo->GRUP_ESTADO = 1;
            $grupo->save();
            $grupo_id = $grupo->GRUP_CODIGO;

            #Log::info('Grupo creado: '.$grupo_id);

            foreach ($horario_dias as $dia) {
                if (isset($horario_horas[$dia])) {
                    $hora = $horario_horas[$dia];
                    $programacion = new Programacion();
                    $programacion->PROG_DIA = $dia;
                    $programacion->PROG_HORA = Carbon::parse($hora)->format('H:i:s');
                    $programacion->GRUP_CODIGO = $grupo_id;
                    $programacion->PROG_FECHING = now();
                    $programacion->PROG_ESTADO = 1;
                    $programacion->save();
                }
            }
            #Log::info('Programacion creada');

            foreach ($cliente as $key => $value) {
                $cartera = new Cartera();
                $cartera->EMPR_CODIGO = auth()->user()->EMPR_CODIGO;
                $cartera->AGEN_CODIGO = $agente;
                $cartera->CLIE_CODIGO = $value['clie_codigo'];
                $cartera->GRUP_CODIGO = $grupo_id;
                $cartera->CART_OPERADOR = auth()->user()->USUA_CODIGO;
                $cartera->C_ESTA_CODIGO = 1;
                $cartera->CART_ESTADO = 1;
                $cartera->save();
            }
            #Log::info('Cartera creada');
            DB::commit();
            return $this->successResponse('Registro guardado correctamente');

        }catch (\Throwable $th) {
            DB::rollBack();
            return $this->errorexceptionResponse($th->getMessage());
        }
    }
    public function dashboard(Request $request)
    {
        try {
            $carteras = Cartera::search($request)
                ->where('EMPR_CODIGO', auth()->user()->EMPR_CODIGO)
                ->where('CART_ESTADO', 1)
                ->orderBy('CART_CODIGO', 'desc')
                ->with(['cliente', 'agente', 'estado']) 
                ->get();
    
            #Métricas generales
            $totalCarteras = $carteras->count();
            $totalClientes = $carteras->pluck('cliente')->unique('CLIE_CODIGO')->count();
            $totalAgentes = $carteras->pluck('agente')->unique('AGEN_CODIGO')->count();

            $totalCompletados = $carteras->where('C_ESTA_CODIGO', 2)->count();
            $totalPendientes = $carteras->where('C_ESTA_CODIGO', 1)->count();

            #Agrupar datos por agente
            $carterasPorAgente = $carteras->groupBy('agente.AGENTE_NOMBRE')->map(function ($group) {
                return $group->count();
            });
    
            $carterasPorEstado = $carteras->groupBy('estado.C_ESTA_NOMBRE')->map->count();
            $labels = $carterasPorEstado->keys()->toArray(); // Nombres de estados
            $values = $carterasPorEstado->values()->toArray();

            #top 10 llamadas de $carteras
            $carteras = $carteras->take(10);


            $enviosPorDia = Cartera::where('EMPR_CODIGO', auth()->user()->EMPR_CODIGO)
            ->where('CART_ESTADO', 1)
            ->selectRaw('EXTRACT(DOW FROM "CART_FECHENVIO") AS dia, COUNT(*) AS total')
            ->groupBy('dia')
            ->pluck('total', 'dia');

            $diasSemana = [
                2 => 'Lun', 3 => 'Mar', 4 => 'Mié', 5 => 'Jue', 6 => 'Vie', 7 => 'Sáb', 1 => 'Dom'
            ];
            $data = [];
            foreach ($diasSemana as $numero => $nombre) {
                $labelsSemana[] = $nombre;
                $dataSemana[] = $enviosPorDia[$numero] ?? 0;
            }

            $data = [
                'total_carteras' => $totalCarteras,
                'total_clientes' => $totalClientes,
                'total_agentes' => $totalAgentes,
                'total_completados' => $totalCompletados,
                'total_pendientes' => $totalPendientes,
                'carteras_por_agente' => $carterasPorAgente,
                //'carteras_por_estado' => $carterasPorEstado,
                'chart_status_labels' => $labels,
                'chart_status_values' => $values,
                'detalle_carteras' => CarteraResource::collection($carteras),
                'cantidad_llamadas_labesl' => $labelsSemana,
                'cantidad_llamadas_values' => $dataSemana,
            ];
    
            return $this->successResponse($data);
    
        } catch (\Throwable $th) {
            return $this->errorexceptionResponse($th->getMessage());
        }
    }
    public function exportExcel(Request $request)
    {
        try {            
            $nombre_file = date('YmdHis') . '.xlsx';
            return Excel::download(new CarteraExport($request), $nombre_file);
            
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }
}