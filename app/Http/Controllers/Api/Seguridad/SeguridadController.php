<?php
namespace App\Http\Controllers\Api\Seguridad;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Http\Controllers\Api\Seguridad\Models\Usuarios;
use App\Http\Controllers\Api\Seguridad\Models\Accesos;
use App\Http\Controllers\Api\Seguridad\Models\Opciones;
use App\Http\Controllers\Api\Seguridad\Models\Permisos;
use App\Http\Controllers\Api\Seguridad\Resources\AccesosLoginPerfilResource;
use App\Http\Controllers\Api\Seguridad\Resources\AccesosUsusarioResource;
use App\Http\Controllers\Api\Seguridad\Resources\UsuaEmpresasResponse;
use App\Http\Controllers\Api\Seguridad\Resources\UsuarioResource;
use Illuminate\Support\Facades\DB;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Mail;
class SeguridadController extends ApiController
{   public function __construct()
    {
        $this->middleware('auth:api')->except(['login', 'resetPassword']);
    }
    public function login(Request $request)
    {   
        $token = null;
        $decoded = null;
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required',
        ], [
            'username.required'   => 'Ingrese usuario.',
            'password.required'    => 'Ingrese contraseña.',
        ]);

        try {
            $model = Usuarios::where('USUA_USERNAME', Str::upper($request->username))->first();
            if (!$model) {
                throw new \Exception('El usuario no existe.');
            }
            
            $validapass = Hash::check($request->password, $model->USUA_PASSWORD);
            if (!$validapass) {
                throw new \Exception('La contraseña es incorrecta.');
            }

            /*$accesos = Accesos::with(['opciones' => function ($query) {
                    $query->where('OPCI_TIPO', 1)
                        ->orderBy('OPCI_ORDER', 'asc');
                }])
                ->whereHas('opciones', function ($query) {
                    $query->where('OPCI_TIPO', 1);
                })
                ->where('ACCE_ESTADO', 1)
                ->where('USUA_CODIGO', $model->USUA_CODIGO)
                ->get();

            if ($accesos->count() > 0):
                $accesos = $accesos->sortBy(function ($acceso, $key) {
                    return $acceso->opciones->OPCI_ORDER;
                });
            endif;*/
            
            $accesos = Permisos::with([
                'opciones' => function ($query) use ($model) {
                    $query->where('OPCI_TIPO', 1)
                        ->orderBy('OPCI_ORDER', 'asc')
                        ->with([
                            'subOpciones' => function ($q) use ($model) {
                                $q->whereHas('permisos', function ($q2) use ($model) {
                                    $q2->where('PERF_CODIGO', $model->PERF_CODIGO);
                                })->with([
                                    'subOpciones' => function ($q) use ($model) {
                                        $q->whereHas('permisos', function ($q2) use ($model) {
                                            $q2->where('PERF_CODIGO', $model->PERF_CODIGO);
                                        })->with([
                                            'subOpciones' => function ($q) use ($model) {
                                                $q->whereHas('permisos', function ($q2) use ($model) {
                                                    $q2->where('PERF_CODIGO', $model->PERF_CODIGO);
                                                });
                                            }
                                        ]);
                                    }
                                ]);
                            }
                        ]);
                }
            ])
            ->whereHas('opciones', function ($query) {
                $query->where('OPCI_TIPO', 1);
            })
            ->where('PERM_ESTADO', 1)
            ->where('PERF_CODIGO', $model->PERF_CODIGO)
            ->get();
            

            // if ($accesos->count() > 0) {
            //     $accesos = $accesos->sortBy('OPCI_ORDER');
            // }
            $expirationTime = time() + (24 * 60 * 60); #24 horas
            $token = $model->createToken('My Token', ['*'])->accessToken;

        } catch (\Exception $e) {
            return $this->errorexceptionResponse($e->getMessage());
        }
        
        return response()->json([
            'access_token' => $token,
            'user' => new UsuarioResource($model),
            #'permisos' => AccesosUsusarioResource::collection($accesos),
            'permisos' => AccesosLoginPerfilResource::collection($accesos),
            'empresa' => UsuaEmpresasResponse::collection($model->usuaEmpresas),
            'code' => 200
        ], 200);
    }

    public function store(Request $request){
        $model = new Usuarios();
        $model->PERF_CODIGO = 1;
        $model->USUA_USERNAME = Str::upper($request->username);
        $model->USUA_PASSWORD = Usuarios::hashPassword($request->password);
        $model->PERS_CODIGO = 1;
        $model->USUA_FECHING = Carbon::now()->format('Y-m-d H:i:s');
        $model->USUA_ESTADO = 1;
        $model->save();
    }
    public function resetPassword(Request $request)
    {
        try {
        
            $usuario = Usuarios::where('USUA_USERNAME', strtoupper($request->username))->first();
            if(!$usuario){
                throw new \Exception('El correo electrónico no se encuentra en nuestros registros');
            }
            $pwd = Usuarios::generarPassword();

            $usuario->USUA_PASSWORD = $usuario::hashPassword($pwd);
            $usuario->save();
            $usuario->pwd = $pwd;
            Notification::send($usuario, new ResetPasswordNotification($usuario));

        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }

        return $this->successResponse();
    }
    public function changePassword(Request $request)
    {
        $this->validate($request, [
            'password' => 'required',
            'password_confirmation' => 'required',
        ]);

        $user = auth()->user();

        if (!$user) {
            return response()->json(['error' => 'invalid_credentials'], 401);
        }
        $user->USUA_PASSWORD = $user::hashPassword($request->password);
        $user->save();

        return response()->json('ok');
    }
    public function logout()
    {
        auth()->user()->tokens->each(function ($token, $key) {
            $token->delete();
        });
        auth('web')->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }
}