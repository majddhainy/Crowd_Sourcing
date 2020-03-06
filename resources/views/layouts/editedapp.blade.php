<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
  

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @yield('css')
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('getlogin') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('getregister'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('getregister') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        <center>
            @yield('content')
        </center>
    </div>
    {{-- now subscribe for channels --}}
    @auth
    <script src="https://js.pusher.com/5.1/pusher.min.js"></script>

    {{-- check if participant to subscribe him for channel specific to the workshop to receive notifications from monitor --}}
    @if(auth()->user()->role==2){
        <script>
            var pusher = new Pusher('1da76367e337a252dc04', {cluster: 'mt1'});
            var channel = pusher.subscribe('participants'+{!! json_encode($workshop->id) !!});
            channel.bind('my-event', function(data) {alert(JSON.stringify(data));});
        </script>
    @else
    {{-- else, monitor, subscribe him for channel specific to his workshop to recieve notification from participants --}}
    <script>
        var pusher = new Pusher('1da76367e337a252dc04', {cluster: 'mt1'});
        var channel = pusher.subscribe('monitor'+{!! json_encode($workshop->id) !!});
        channel.bind('my-event', function(data) {alert(JSON.stringify(data));});
    </script>
    @endif
    @endauth
    <script src="{{ asset('js/app.js') }}"></script>
    @yield('scripts')
</body></html>