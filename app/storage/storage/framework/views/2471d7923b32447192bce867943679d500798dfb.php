<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="https://cdn.vuetifyjs.com/images/logos/vuetify-logo-dark.png" type="image/x-icon" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo e(config('app.name', 'Laravel')); ?></title>
    <!-- Styles -->
    <link href="<?php echo e(asset('public/css/app.css')); ?>" rel="stylesheet">
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
    <input type="hidden" value="<?php echo e(Request::root()); ?>" id="baseURL">

    <div id="app" v-cloak>
    </div>
    <script src="<?php echo e(asset('public/js/manifest.js?v=')); ?><?php echo date('Ymdhi'); ?>"></script>
    <script src="<?php echo e(asset('public/js/vendor.js?v=')); ?><?php echo date('Ymdhi'); ?>"></script>
    <script src="<?php echo e(asset('public/js/app.js?v=')); ?><?php echo date('Ymdhi'); ?>"></script>
</body>

</html>
<?php /**PATH C:\laragon\www\call\resources\views/app.blade.php ENDPATH**/ ?>