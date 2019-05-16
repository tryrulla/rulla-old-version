<div class="w-auto h-16 flex items-center bg-white shadow px-4 flex justify-between">
    <div>
        <span class="font-bold text-lg">
            {{ config('app.name') }}
        </span>

        <form action="{{ route('search') }}" method="get" class="inline-block mx-4">
            <input class="input-text" name="query" placeholder="Search Anything">
        </form>
    </div>

    <div>
        @auth
            [{{ Auth::user()->identifier }}] {{ Auth::user()->name }} ({{ Auth::user()->username }})
        @else
            <a href="{{ route(env('LOGIN_PROVIDER', 'saml2') === 'saml2' ? 'saml_login' : 'login') }}">Log in</a>
        @endauth
    </div>
</div>
