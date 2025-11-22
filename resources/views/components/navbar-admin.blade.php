<nav class="bg-white shadow-md sticky top-0 z-50" 
     x-data="{ openMenu: false, profileOpen: false }">

    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">

            <!-- Logo Admin -->
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2">
                <div class="h-8 w-8 bg-emerald-600 rounded-lg flex items-center justify-center shadow">
                    <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                </div>
                <span class="text-xl font-bold text-emerald-700">Forest Admin</span>
            </a>

            <!-- Desktop Menu -->
            <div class="hidden md:flex items-center space-x-6">

                @php
                    // Kelas untuk link aktif & tidak aktif
                    $navClass = "px-3 py-2 text-sm font-medium transition rounded-md";
                    $active = "text-emerald-700 bg-emerald-50 font-bold";
                    $inactive = "text-gray-600 hover:text-emerald-600 hover:bg-gray-50";
                @endphp

                <a href="{{ route('admin.dashboard') }}" class="{{ $navClass }} {{ request()->routeIs('admin.dashboard') ? $active : $inactive }}">Dashboard</a>
                <a href="{{ route('admin.items.index') }}" class="{{ $navClass }} {{ request()->routeIs('admin.items.*') ? $active : $inactive }}">Items</a>
                <a href="{{ route('admin.rentals.index') }}" class="{{ $navClass }} {{ request()->routeIs('admin.rentals.*') ? $active : $inactive }}">Rentals</a>
                <a href="{{ route('admin.categories.index') }}" class="{{ $navClass }} {{ request()->routeIs('admin.categories.*') ? $active : $inactive }}">Categories</a>
            </div>

            <!-- Profile Dropdown -->
            <div class="hidden md:flex relative">

                <!-- Tombol profile -->
                <button @click="profileOpen = !profileOpen"
                        class="flex items-center gap-2 px-3 py-1 rounded-lg hover:bg-gray-100 transition">

                    {{-- Avatar otomatis: upload > inisial --}}
                    @if(Auth::user()->avatar)
                        <img src="{{ asset('storage/' . Auth::user()->avatar) }}" 
                             class="h-8 w-8 rounded-full object-cover border border-gray-200">
                    @else
                        <div class="h-8 w-8 bg-emerald-600 text-white rounded-full flex items-center justify-center font-bold text-sm">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                    @endif

                    <span class="text-sm text-gray-700 font-medium">{{ Auth::user()->name }}</span>

                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>

                <!-- Dropdown -->
                <div x-show="profileOpen"
                     @click.away="profileOpen = false"
                     x-transition
                     class="absolute right-0 mt-3 w-48 bg-white rounded-xl shadow-xl border border-gray-100 py-2 z-50"
                     style="display:none">

                    <div class="px-4 py-2 border-b border-gray-100 mb-1">
                        <p class="text-xs text-gray-500">Admin Account</p>
                        <p class="font-bold text-gray-800 truncate">{{ Auth::user()->name }}</p>
                    </div>

                    <!-- Edit Profil Admin -->
                    <a href="{{ route('admin.profile') }}" 
                       class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-emerald-50 hover:text-emerald-600 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        Edit Profile
                    </a>

                    <div class="border-t border-gray-100 my-1"></div>

                    <!-- Logout -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                                class="flex items-center gap-2 w-full px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                            Logout
                        </button>
                    </form>
                </div>
            </div>

            <!-- Mobile Button -->
            <button @click="openMenu = !openMenu" class="md:hidden text-gray-700">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>

        </div>
    </div>

    <!-- Mobile Menu -->
    <div x-show="openMenu"
         class="md:hidden bg-white border-t px-4 py-4 space-y-2"
         style="display:none">

        <a href="{{ route('admin.dashboard') }}" class="block text-gray-700 hover:text-emerald-600 font-medium py-2">Dashboard</a>
        <a href="{{ route('admin.items.index') }}" class="block text-gray-700 hover:text-emerald-600 font-medium py-2">Items</a>
        <a href="{{ route('admin.rentals.index') }}" class="block text-gray-700 hover:text-emerald-600 font-medium py-2">Rentals</a>
        <a href="{{ route('admin.categories.index') }}" class="block text-gray-700 hover:text-emerald-600 font-medium py-2">Categories</a>

        <div class="border-t border-gray-100 my-2"></div>

        <a href="{{ route('admin.profile') }}" class="block text-gray-700 hover:text-emerald-600 font-medium py-2">Edit Profile</a>

        <a href="{{ route('logout') }}"
           onclick="event.preventDefault(); document.getElementById('logout-form-mobile').submit();"
           class="block text-red-600 font-medium py-2">
           Logout
        </a>

        <form id="logout-form-mobile" action="{{ route('logout') }}" method="POST" class="hidden">
            @csrf
        </form>
    </div>
</nav>
