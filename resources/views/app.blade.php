<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{-- <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests" /> --}}
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="https://cdn.vuetifyjs.com/images/logos/vuetify-logo-dark.png" type="image/x-icon" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Styles -->
    <link href="{{ asset('public/css/app.css') }}" rel="stylesheet">
    <style>
        [v-cloak] {
            display: none
        }
    </style>

    <script type="application/javascript">
                var APP = {};
                APP.APP_URL = '<?php echo config('app.url')?>';	
                APP.APP_NAME = '<?php echo config('app.name')?>';		                
                APP.APP_VERSION = '<?php echo config('app.version')?>';
        </script>

</head>

<body>
    <input type="hidden" value="{{ Request::root() }}" id="baseURL">

    <div id="app" v-cloak>
    </div>
    <script src="{{ asset('public/js/manifest.js?v=') }}<?php echo date('Ymdhi'); ?>"></script>
    <script src="{{ asset('public/js/vendor.js?v=') }}<?php echo date('Ymdhi'); ?>"></script>
    <script src="{{ asset('public/js/app.js?v=') }}<?php echo date('Ymdhi'); ?>"></script>
</body>

</html>
