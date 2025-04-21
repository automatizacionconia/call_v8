<?php

return [

    /*
    |--------------------------------------------------------------------------
    | SGD
    |--------------------------------------------------------------------------
    |
    | Config
    |
    */

    /*
    |--------------------------------------------------------------------------
    | mesa de partes
    |--------------------------------------------------------------------------
    |    
    |
    */

    'mp' => [
        'sigla' => env('SGD_MP_SIGLA', 'MP'),
        'ccod_origing' => env('CCOD_ORIGING', '03'), //Mesa de Partes
        'co_dep_mpv' => env('CO_DEP_MPV', '10051'), //Código mesa de partes virtual
        'host' => env('SGD_HOST','')
    ],
    'estado' => [
        'registrado' => env('SGD_EST_REG', '5'),
        'verificar' => env('SGD_EST_VER', '7'),
        'observado' => env('SGD_EST_OBS', '10'),
        'subsanado' => env('SGD_EST_SUB', '11'),
        'ingresado' => env('SGD_EST_ING', '0'),
        'anulado' => env('SGD_EST_ANU', '9'),
        'finalizado' => env('SGD_EST_DER', '12'),
    ],
    'estado_destino' => [
        'no_leido' => env('SGD_EST_NOL', '0'),
        'recepcionado' => env('SGD_EST_REC', '1'),
        'atendido' => env('SGD_EST_ATE', '2'),
        'archivado' => env('SGD_EST_ARC', '3'),
        'derivado' => env('SGD_EST_DER', '4'),
        'enviado' => env('SGD_EST_ENV', '5'),
        'anulado' => env('SGD_EST_ANU_DES', '9'),
    ],
    'tipo_emi' => [
        'interno' => env('SGD_TIP_EMI_INT', '01'),
        'juridica' => env('SGD_TIP_EMI_JUR', '02'),
        'cuidadano' => env('SGD_TIP_EMI_CUI', '03'),
        'otros' => env('SGD_TIP_EMI_OTR', '04'),
        'personal' => env('SGD_TIP_EMI_PER', '05'),
    ],
    'co_grupo' => [
        'interno' => env('SGD_CO_GRU_INT', '1'),
        'personal' => env('SGD_CO_GRU_PER', '2'),
        'externo' => env('SGD_CO_GRU_EXT', '3'),
    ],
    'expediente' => [
        'co_proceso' => env('SGD_TIP_EMI_CUI', '0000'),
    ],
    'empresa' => [
        'co_local' => env('SGD_EMP_LOC_EMI', '001'),
        'codigo' => env('ENTIDAD_APP_CODIGO', '0002'),
    ],
    'remito' => [
        'remi_ti_emi' => env('SGD_REM_TI_EMI', '03'),
        'remi_nu_dni_emi' => env('SGD_REM_NU_DNI_EMI', '00000000'),
        'ccod_dpto' => env('SGD_REM_DPTO', '24'),
        'ccod_prov' => env('SGD_REM_PROV', '01'),
        'ccod_dist' => env('SGD_REM_DIST', '01'),
    ],
    'seguridad' => [
        'cod_user_admin' => env('COD_USER_ADMIN', 'ADMIN'),
    ],
    'secret_key_password'=> env('SGD_SECRET_KEY_PASSWORD', 'SgDPasswordSecretPasswor')
];
