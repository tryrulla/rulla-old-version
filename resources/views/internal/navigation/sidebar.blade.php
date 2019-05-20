<sidebar>
    @auth
        <div class="p-4">
            <div class="navbar-grid">
                <router-link :to="{ name: 'types.index' }">
                    <i class="fas fa-boxes"></i>
                    <span>Types</span>
                </router-link>

                <router-link :to="{ name: 'instances.index' }">
                    <i class="fas fa-box-open"></i>
                    <span>Instances</span>
                </router-link>

                <router-link :to="{ name: 'locations.index' }">
                    <i class="fas fa-warehouse"></i>
                    <span>Locations</span>
                </router-link>

                <router-link :to="{ name: 'reservations.index' }">
                    <i class="fas fa-clipboard-list"></i>
                    <span>Reservations</span>
                </router-link>

                <router-link :to="{ name: 'users.index' }">
                    <i class="fas fa-user"></i>
                    <span>Users</span>
                </router-link>
            </div>

            @if(env('LOGIN_PROVIDER', 'saml2') !== 'env')
                <div class="navbar-grid mt-4">
                    <a href="{{ route('logout') }}"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Log out</span>
                    </a>
                </div>
            @endif
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

    <div class="p-4 text-xs text-gray-700">
        Powered by
        <a href="https://rulla.gitlab.io" class="text-gray-900 hover:underline">Rulla Inventory Management</a>.
    </div>
</sidebar>
