<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" />

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.6/examples/carousel/">

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <style>
        .links>a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        #demo {
            color: #397a7a;
            border: 2px solid #397a7a;
            border-radius: 3rem;
            float: right;
            margin-right: 1rem;
            margin-top: 10px;
            margin-bottom: 10px;
            font-size: 1.5rem;
            padding: 0.5rem 1rem;
            /*margin: 0 0;*/
            position: relative;
        }
        @media (max-width: 575.98px) {
            #demo {
                font-size: 0.8rem;
            }
        }

        @media (max-width: 767.98px) {
            #demo {
                font-size: 1rem;
            }
        }

        @media (max-width: 991.98px) {
            #demo {
                font-size: 1rem;
            }
        }
        @media (max-width: 1199.98px) {
            #demo {
                font-size: 1rem;
            }
        }

    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.css">


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- CSS LOCAL -->
    @yield('css')

</head>

<body id="table_data">
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <a class="navbar-brand" href="{{ url('/') }}">
            Site
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="container">

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->

                <ul class="navbar-nav mr-auto">
                    @auth
                        <a href="{{ url('/home') }}" class="navbar-brand">Home</a>
                        <a href="{{ route('agenda.index') }}" class="navbar-brand">Agenda</a>
                        <a href="{{ route('discografia.index') }}" class="navbar-brand">Discografica</a>
                        <a href="{{ route('galerias.index') }}" class="navbar-brand">Galeria</a>
                        <a href="{{ route('music.index') }}" class="navbar-brand">Play Music</a>

                    @endauth

                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->

                    @guest
                        <div class="top-right links">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </div>
                        @if (Route::has('register'))
                            <div class="top-right links">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </div>
                        @endif

                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
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
                    @endguest
                </ul>
            </div>
        </div>
    </nav>
    <div id="app">
        @if (!empty(Auth::user()->id))
            <div id="demo"></div>
        @endif

        <main class="py-4">
            <div class="container">
                @yield('content')
            </div>

        </main>
    </div>

    <script>
        var myVar = setInterval(myTimer, 1000);

        function myTimer() {
            var d = new Date(),
                displayDate;
            if (navigator.userAgent.toLowerCase().indexOf('') > -1) {
                displayDate = d.toLocaleTimeString(navigator.language);
            } else {
                displayDate = d.toLocaleTimeString(navigator.language, {
                    timeZone: Intl.DateTimeFormat().resolvedOptions().timeZone
                });
            }
            document.getElementById("demo").innerHTML = displayDate;
        }

    </script>

    <script>
        /*var txt = "";
        txt += "<p>Browser Name: " + navigator.appName + "</p>"
        txt += "<p>Browser CodeName: " + navigator.appCodeName + "</p>";
        txt += "<p>Browser Name: " + navigator.appName + "</p>";
        txt += "<p>Browser Version: " + navigator.appVersion + "</p>";
        txt += "<p>Cookies Enabled: " + navigator.cookieEnabled + "</p>";
        txt += "<p>Browser Language: " + navigator.language + "</p>";
        txt += "<p>Browser Online: " + navigator.onLine + "</p>";
        txt += "<p>Platform: " + navigator.platform + "</p>";
        txt += "<p>User-agent header: " + navigator.userAgent + "</p>";
        txt += "<p>timeZone: " + Intl.DateTimeFormat().resolvedOptions().timeZone + "</p>";
        console.log(txt);*/

    </script>


    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

    <!-- Scripts -->
    <script src="{{-- asset('js/pace.min.js') --}}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


    @yield('scripts')
    @yield('scripts2')

</body>

</html>
