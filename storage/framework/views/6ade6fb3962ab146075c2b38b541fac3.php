<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

        <title><?php echo e(config('app.name', 'Laravel')); ?></title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Prod -->

         <link rel="stylesheet" href="https://dev.ufoway.com.br/v4/build/assets/app-e221511c.css" /> 

    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
            <div>
                <a href="/">
                    <img src="/img/logo-no-background.png" width="300" height="300">
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                <?php echo e($slot); ?>

            </div>
        </div>

        <!-- Prod -->

        <script src="https://dev.ufoway.com.br/v4/build/assets/app-1cfa0830.js" ></script> 
    </body>
</html>
<?php /**PATH /home/ufowayco/CeosV4/Ceos/resources/views/layouts/guest.blade.php ENDPATH**/ ?>