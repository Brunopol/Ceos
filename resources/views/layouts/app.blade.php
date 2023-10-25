<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <link href="https://cdn.datatables.net/v/dt/jq-3.7.0/jszip-3.10.1/dt-1.13.6/b-2.4.2/b-html5-2.4.2/b-print-2.4.2/sb-1.6.0/sp-2.2.0/datatables.min.css" rel="stylesheet">
 
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/v/dt/jq-3.7.0/jszip-3.10.1/dt-1.13.6/b-2.4.2/b-html5-2.4.2/b-print-2.4.2/sb-1.6.0/sp-2.2.0/datatables.min.js"></script>


    <!-- Prod -->

        <link rel="stylesheet" href="https://dev.ufoway.com.br/v4/build/assets/app-e221511c.css" />  
        
        
        
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

        <!-- Page Heading -->
        @if (isset($header))
            <header class="bg-grey shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>

    <!-- Prod -->

        <script src="https://dev.ufoway.com.br/v4/build/assets/app-1cfa0830.js" ></script> 
    </body>
</html>
