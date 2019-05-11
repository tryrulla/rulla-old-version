<div class="flex-none w-full md:max-w-xs text-black bg-gray-300">
    <div class="px-4 h-16 bg-gray-400 text-xl font-mono flex items-center">
        <a href="{{ route('home') }}">
            Rulla
        </a>
    </div>

    @auth
        <div class="p-4">
            <div class="navbar-grid">
                <a href="{{ route('types.index') }}">
                    <i class="fas fa-boxes"></i>
                    <span>Types</span>
                </a>

                <a href="{{ route('instances.index') }}">
                    <i class="fas fa-box-open"></i>
                    <span>Instances</span>
                </a>

                <a href="{{ route('locations.index') }}">
                    <i class="fas fa-warehouse"></i>
                    <span>Locations</span>
                </a>

                <a href="{{ route('reservations.index') }}">
                    <i class="fas fa-clipboard-list"></i>
                    <span>Reservations</span>
                </a>
            </div>

            <div class="navbar-grid mt-4">
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Log out</span>
                </a>
            </div>
        </div>
    @else
        <div class="p-4">
            <div class="navbar-grid">
                <a href="{{ route('login') }}">
                    <i class="fas fa-sign-in-alt"></i>
                    Log in
                </a>
            </div>
        </div>
    @endauth
</div>
