<div class="w-auto h-16 flex items-center bg-white shadow px-4 flex justify-between">
    <div>
        <span class="font-bold">
            {{ config('app.name') }}
        </span>
    </div>

    <div>
        @auth
            [{{ Auth::user()->identifier }}] {{ Auth::user()->name }} ({{ Auth::user()->username }})
        @else
            <a href="{{ route('login') }}">Log in</a>
        @endauth
    </div>
</div>
