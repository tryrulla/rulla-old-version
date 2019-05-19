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
                <a href="{{ route(env('LOGIN_PROVIDER', 'saml2') === 'saml2' ? 'saml_login' : 'login') }}">
                    <i class="fas fa-sign-in-alt"></i>
                    Log in
                </a>
            </div>
        </div>
    @endauth
</sidebar>
