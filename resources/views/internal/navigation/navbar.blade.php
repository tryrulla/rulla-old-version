<div class="w-auto h-16 flex items-center bg-white shadow px-4 flex justify-between">
    <div>
        <span class="font-bold text-lg">
            {{ config('app.name') }}
        </span>

        <form action="{{ route('search') }}" method="get" class="block md:inline-block md:mx-4">
            <input class="input-text" name="query" placeholder="Search Anything (beta)">
        </form>
    </div>

    <div class="text-right">
        @auth
            [{{ Auth::user()->identifier }}] {{ Auth::user()->name }} ({{ Auth::user()->username }})
        @else
            <a href="{{ route('login') }}">Log in</a>
        @endauth
    </div>
</div>
