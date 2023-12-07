<x-app-layout>

    <script>
        var csrfToken = '{{ csrf_token() }}';
    </script>


    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Módulo Controle De Acesso') }}
        </h2>
    </x-slot>




    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    

                    test


                </div>
            </div>
        </div>
    </div>

    
</x-app-layout>


<script src="{{ asset('javascript/chaves.js') }}"></script>
