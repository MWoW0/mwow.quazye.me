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

    <!-- Laravel scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'translations' => json_decode(file_get_contents(resource_path('lang/'.app()->getLocale().'.json')), true),
            'algolia' => [
                'id' => config('services.algolia.id'),
                'search_secret' => config('services.algolia.search_secret')
            ],
        ]); ?>
    </script>
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
                        <router-link :to="{ name: 'home.dashboard' }" class="mx-2 no-underline border-b-2 hover:border-blue-dark text-sm font-normal text-grey-darker">
                            {{ __('Home') }}
                        </router-link>

                        <router-link :to="{ name: 'community' }" class="mx-2 no-underline border-b-2 hover:border-blue-dark text-sm font-normal text-grey-darker">
                            {{ __('Community') }}
                        </router-link>
                    @endif
                </div>

                <div class="flex-1 text-right">
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
                </div>
            </div>
        </div>
    </nav>

    <transition name="fade">
        <router-view></router-view>
    </transition>
</div>

<!-- Scripts -->
<script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
