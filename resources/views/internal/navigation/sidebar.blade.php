<div class="flex-none w-full md:max-w-xs bg-gray-800 text-white">
    <div class="px-4 h-16 bg-black text-xl font-mono flex items-center">
        <a href="{{ route('home') }}">
            Rulla
        </a>
    </div>

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
        </div>
    </div>
</div>
