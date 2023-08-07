<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Users') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <table id="myTable" class="display">
                        <thead>
                            <tr>
                                <th>name</th>
                                <th>email</th>
                                <th>created_at</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>

   <script type="module">
       
        $('#myTable').DataTable( {
            ajax: {
                url: "{{ route('ajax') }}",
                dataSrc: 'users'
            },
            columns: [ 
                { data: 'name' },
                { data: 'email' },
                { data: 'created_at' }
             ]
        } );
    </script>

