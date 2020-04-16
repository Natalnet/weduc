<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>sBotics</title>

    <!-- Styles -->
    <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
</head>
<body>
<div class=" h-screen bg-scroll overflow-hidden flex justify-end"
     style="background-image: url({{ asset('images/sbotics.gif') }}); background-size: cover;">
    {{--    <img class=" h-56 w-full object-scale-down sm:h-72 md:h-96 lg:w-full lg:h-full" src="" alt="" />--}}
    <div class="max-w-screen-xl">
        <div class=" z-10 pb-8 bg-white lg:max-w-xl lg:w-full rounded-l-lg">

            <div class="mt-10 mx-auto max-w-screen-l p-4 py-8 sm:mt-12 sm:px-6 md:mt-16 lg:mt-20 lg:px-8 xl:mt-28">
                <div class="sm:text-center lg:text-left">
                    <div class="flex justify-center">

                        <img src="{{ asset('images/sbotics-logo.svg') }}">
                    </div>
                    <p class="mt-3 text-base text-gray-500 sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-5 md:text-xl lg:mx-0">
                        O sBotics é uma plataforma de simulação dos níveis 1 e 2 da prova prática da Olímpiada
                        Brasileira de Robótica. Na abordagem comum desta prova utiliza-se kits e robótica para simular o
                        resgate de uma vítima em um ambiente de desastre. O sBotics oferece uma alternativa para aqueles
                        que desejam testar seus conhecimentos de programação.
                    </p>
                    <div class="mt-5 sm:mt-8 sm:flex sm:justify-center lg:justify-end">
                        <div class="rounded-md shadow">
                            <a href="https://www.dropbox.com/sh/vhxr7zpjup0l3ya/AAAS8_7-LklOXyfwqNbObTgBa?dl=0"
                               target="_blank"
                               class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base leading-6 font-medium rounded-md text-white bg-teal-600 hover:bg-teal-500 focus:outline-none focus:shadow-outline transition duration-150 ease-in-out md:py-4 md:text-lg md:px-10">
                                Baixar
                            </a>
                        </div>
                        @guest
                            @if (Route::has('register'))
                                <div class="mt-3 sm:mt-0 sm:ml-3">
                                    <a href="{{ route('register', ['redirect' => 'sbotics']) }}"
                                       class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base leading-6 font-medium rounded-md text-teal-700 bg-teal-100 hover:text-teal-600 hover:bg-teal-50 focus:outline-none focus:shadow-outline focus:border-teal-300 transition duration-150 ease-in-out md:py-4 md:text-lg md:px-10">
                                        Cadastre-se
                                    </a>
                                </div>
                            @endif
                        @endguest
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
