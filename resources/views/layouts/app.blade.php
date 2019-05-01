@extends('layouts.master')

@section('body')
    <div id="app" class="md:flex min-h-screen">
        @include('internal.navigation.sidebar')

        <div class="w-full">
            @include('internal.navigation.navbar')

            <div class="content p-6">
                @if (session('status'))
                    <div>
                        <div class="bg-{{ session('status-color', 'blue') }}-200 border border-{{ session('status-color', 'blue') }}-300 text-{{ session('status-color', 'blue') }}-800 px-4 py-3 rounded relative my-4" role="alert">
                            {{ session('status') }}
                        </div>
                    </div>
                @endif

                @yield('content')
            </div>
        </div>

        <portal-target name="modals"></portal-target>
    </div>
@endsection
