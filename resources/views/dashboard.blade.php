<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Painel') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="grid grid-cols-1 gap-6 p-6 text-gray-900 md:grid-cols-2">

                    @if (
                        !auth()->user()->can('users') &&
                            !auth()->user()->can('encaixeVisualizar') &&
                            !auth()->user()->can('controleDeAcessos'))
                        <div class="w-full rounded-md border border-gray-300 bg-gray-100 px-6 py-4 text-gray-700">
                            <strong class="text-lg font-bold">Sem acesso para módulos</strong>
                            <p class="mt-2">Você não tem permissão para acessar nenhum módulo. Para solicitar acesso,
                                entre em contato com a equipe de TI na UFO, ramal 9433, ou abra um chamado <a
                                    href="https://intra.ufoway.com.br/minha-intra/helpdesk/todos"
                                    class="underline">aqui</a>.</p>
                        </div>
                    @endif

                    @can('users')
                        <a href="{{ route('users') }}"
                            class="flex flex-col items-center rounded-lg border border-gray-200 bg-white shadow hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700">
                            <img class="h-96 w-full rounded-t-lg object-cover md:h-auto md:w-48 md:rounded-none md:rounded-s-lg"
                                src="img/users.png" alt="">
                            <div class="flex flex-col justify-between p-4 leading-normal">
                                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Módulo de
                                    Usuários</h5>
                                <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">Controle total sobre as
                                    permissões, gestão eficiente de dados e redefinição de senhas para administradores de
                                    TI.</p>
                            </div>
                        </a>
                    @endcan

                    @can('encaixeVisualizar')
                        <a href="{{ route('encaixe') }}"
                            class="flex flex-col items-center rounded-lg border border-gray-200 bg-white shadow hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700">
                            <img class="h-96 w-full rounded-t-lg object-cover md:h-auto md:w-48 md:rounded-none md:rounded-s-lg"
                                src="img/encaixe.png" alt="">
                            <div class="flex flex-col justify-between p-4 leading-normal">
                                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Módulo de
                                    Encaixe</h5>
                                <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">Plataforma centralizada para
                                    cadastro de referências, movimentos e consumos, com versão intuitiva de visualização.
                                </p>
                            </div>
                        </a>
                    @endcan

                    @can('controleDeAcessos')
                        <a href="{{ route('controleDeAcessos') }}"
                            class="flex flex-col items-center rounded-lg border border-gray-200 bg-white shadow hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700">
                            <img class="h-96 w-full rounded-t-lg object-cover md:h-auto md:w-48 md:rounded-none md:rounded-s-lg"
                                src="img/controledeacesso.png" alt="">
                            <div class="flex flex-col justify-between p-4 leading-normal">
                                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Módulo de
                                    Controle de Acessos</h5>
                                <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">Simplifica o gerenciamento de
                                    entrada e saída, registrando dados e oferecendo visualização com permissões específicas.
                                </p>
                            </div>
                        </a>
                    @endcan

                    @can('chaves')
                        <a href="{{ route('chaves') }}"
                            class="flex flex-col items-center rounded-lg border border-gray-200 bg-white shadow hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700">
                            <img class="h-96 w-full rounded-t-lg object-cover md:h-auto md:w-48 md:rounded-none md:rounded-s-lg"
                                src="img/chaves.png" alt="">
                            <div class="flex flex-col justify-between p-4 leading-normal">
                                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Módulo de
                                    Chaves</h5>
                                <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">Simplifica o gerenciamento de
                                    entrada e saída de chaves.
                                </p>
                            </div>
                        </a>
                    @endcan

                </div>
            </div>
        </div>
    </div>

</x-app-layout>
