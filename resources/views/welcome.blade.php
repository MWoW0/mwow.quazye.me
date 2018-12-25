@extends('layouts.app')

@section('content')
    <div class="flex flex-col">
        <div class="min-h-screen flex items-center justify-center">
            <div class="flex flex-col justify-around w-full h-full">
                <div>
                    <h1 class="text-grey-darker text-center font-thin tracking-wide text-5xl mb-6">
                        {{ config('app.name', 'Laravel') }}
                    </h1>
                </div>

                <div class="font-sans text-center items-center justify-center rounded min-w-full w-full py-8">
                    @foreach($realms as $realm)
                        <div class="overflow-hidden bg-white rounded min-w-full w-full shadow-lg  leading-normal">
                            <div class="block group p-4 border-b">
                                <p class="font-bold text-lg mb-1 text-black">
                                    <img src='{{ Storage::url("expansions/{$realm->expansion}.png") }}'
                                         alt="{{ $realm->expansion }}"> {{ $realm->name }}
                                </p>
                                <p class="text-grey-darker mb-2 group-hover:text-white">
                                    {{ __(':count Active players', ['count' => App\Account::active()->count()]) }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
