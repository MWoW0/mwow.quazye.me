<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>
<body class="bg-grey-lightest h-screen antialiased">
    <div id="app">
        <nav class="bg-white h-12 shadow px-6 md:px-0 mb-4">
            <div class="mx-2 h-full">
                <div class="flex items-center justify-center h-12">
                    <div class="mr-2">
                        <a href="{{ url('/') }}" class="text-lg font-hairline text-grey-darker no-underline hover:underline">
                            {{ config('app.name', 'Laravel') }}
                        </a>
                    </div>
                    <div class="flex-1">
                        @if(Auth::check())
                            <a href="{{ url('/home') }}" class="no-underline hover:underline text-sm font-normal text-grey-darker">{{ __('Home') }}</a>
                        @endif
                    </div>

                    <div class="flex-1 text-right">
                        @guest
                            <a class="no-underline hover:underline text-grey-darker pr-3 text-sm" href="{{ url('/login') }}">{{ __('Login') }}</a>
                            <a class="no-underline hover:underline text-grey-darker text-sm" href="{{ url('/register') }}">{{ __('Register') }}</a>
                        @else
                            @admin
                                <a class="no-underline hover:underline text-red-darker text-sm" href="{{ url('/admin') }}">{{ __('Admin') }}</a>
                            @endadmin
                            <a href="{{ route('logout') }}"
                                class="no-underline hover:underline text-grey-darker text-sm"
                                onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">{{ __('Logout') }}</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                                {{ csrf_field() }}
                            </form>
                        @endguest
                    </div>
                </div>
            </div>
        </nav>
        @if(session('status'))
            <div class="bg-blue-dark border-t-4 border-grey rounded-b text-white px-4 py-3 shadow-md my-2" role="alert">
                <div class="flex">
                    <svg class="h-6 w-6 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/></svg>
                    <p class="text-bold">{{ session('status') }}</p>
                </div>
            </div>
        @endif

        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
