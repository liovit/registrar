<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ __('Registrar') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="//cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js" defer></script>
    <script src="https://kit.fontawesome.com/1fa8976130.js" crossorigin="anonymous"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <link rel="stylesheet" href="//cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"/>

</head>
<body>
    @php
        if(!session()->has('locale')) { session()->put('locale', 'lt'); }
    @endphp
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ __('Registrar') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                        @auth
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('companies.index') }}">{{ __('Companies') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('workers.index') }}">{{ __('Workers') }}</a>
                        </li>
                        @endauth

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif
                        {{-- Language link --}}
                            <li class="nav-item">
                                <a href="{{ route('changelang') }}">
                                    @if(session()->get('locale') == 'en')
                                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/1/11/Flag_of_Lithuania.svg/320px-Flag_of_Lithuania.svg.png" class="language-image" data-toggle="tooltip" data-placement="bottom" title="Keisti kalbą į Lietuvių" alt=""> 
                                    @else
                                    <img src="https://upload.wikimedia.org/wikipedia/en/a/aa/English_Language_Flag.png" class="language-image" data-toggle="tooltip" title="Change language to English" data-placement="bottom" alt="">@endif
                                </a>
                            </li>
                        {{-- Language link end --}}

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('changelang') }}">
                                    @if(session()->get('locale') == 'en')
                                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/1/11/Flag_of_Lithuania.svg/320px-Flag_of_Lithuania.svg.png" data-toggle="tooltip" title="Keisti kalbą į Lietuvių" class="language-image" alt=""> 
                                    @else
                                    <img src="https://upload.wikimedia.org/wikipedia/en/a/aa/English_Language_Flag.png" class="language-image" data-toggle="tooltip" title="Change language to English" alt="">@endif
                                </a>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>

    @yield('scripts')
    <script>

        $(document).ready(function(){
            
            $('[data-toggle="tooltip"]').tooltip(); 

            var Language = $('html').attr('lang');

            if(Language == 'lt') {
                $('.table').DataTable({
                    "language": {
                        "url" : "//cdn.datatables.net/plug-ins/1.11.3/i18n/lt.json"
                    }
                });
            } else {
                $('.table').DataTable({
                    "language": {
                        "url" : "//cdn.datatables.net/plug-ins/1.11.3/i18n/en-gb.json"
                    }
                });
            }

        });
    </script>

</body>
</html>
