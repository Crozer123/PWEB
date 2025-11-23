<nav class="bg-white border-b border-gray-100 shadow-sm sticky top-0 z-50" 
     x-data="{ menuOpen: false, profileOpen: false }">

    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">

            <!-- Logo -->
            <a href="{{ route('customer.dashboard') }}" 
               class="text-xl font-bold text-emerald-600 tracking-wide flex items-center gap-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                For Rest Adventure
            </a>

            <!-- Desktop Menu -->
            <div class="hidden sm:flex items-center space-x-8">

                @php
                    // Styling link aktif & tidak aktif
                    $linkClass = "text-sm font-medium transition border-b-2";
                    $activeC = "border-emerald-500 text-emerald-700";
                    $inactiveC = "border-transparent text-gray-600 hover:text-gray-800 hover:border-gray-300";
                @endphp

                <a href="{{ route('customer.dashboard') }}" 
                   class="{{ $linkClass }} {{ request()->routeIs('customer.dashboard') ? $activeC : $inactiveC }}">
                    Dashboard
                </a>

                <a href="{{ route('customer.catalog.index') }}" 
                   class="{{ $linkClass }} {{ request()->routeIs('customer.catalog.index') ? $activeC : $inactiveC }}">
                    Katalog
                </a>

                <a href="{{ route('customer.artikel.carasewa') }}" class="block py-2 text-gray-700 font-medium">
                    Cara Sewa
                </a>

                <a href="{{ route('customer.rentals.history') }}" 
                   class="{{ $linkClass }} {{ request()->routeIs('customer.rentals.history') ? $activeC : $inactiveC }}">
                    Pesanan Saya
                </a>
            </div>

            <!-- Desktop Profile Dropdown -->
            <div class="hidden sm:flex items-center relative">

                <!-- Tombol open profile menu -->
                <button @click="profileOpen = !profileOpen"
                        class="flex items-center gap-2 hover:bg-gray-50 px-3 py-1.5 rounded-full transition border border-transparent hover:border-gray-200">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=10b981&color=fff" 
                         class="w-8 h-8 rounded-full">
                    <span class="font-medium text-sm text-gray-700">{{ Auth::user()->name }}</span>

                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <!-- Menu dropdown -->
                <div x-show="profileOpen" 
                     @click.away="profileOpen = false"
                     x-transition
                     class="absolute right-0 top-12 w-48 bg-white rounded-xl shadow-xl border border-gray-100 py-2 z-50"
                     style="display:none">

                    <div class="px-4 py-2 border-b border-gray-100">
                        <p class="text-xs text-gray-500">Login sebagai</p>
                        <p class="font-bold text-gray-800 truncate">{{ Auth::user()->name }}</p>
                    </div>

                    <!-- Link Edit Profil -->
                    <a href="{{ route('customer.profile.edit') }}" 
                       class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                        Edit Profil
                    </a>

                    <!-- Logout -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" 
                                class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                            Keluar
                        </button>
                    </form>
                </div>
            </div>

            <!-- Mobile Toggle Menu -->
            <div class="flex items-center sm:hidden">
                <button @click="menuOpen = !menuOpen" class="p-2 text-gray-600">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>

        </div>
    </div>

    <!-- Mobile Menu -->
    <div x-show="menuOpen" 
         class="sm:hidden bg-white border-t p-4 space-y-2"
         style="display:none">

        <a href="{{ route('customer.dashboard') }}" class="block py-2 text-gray-700 font-medium">
            Dashboard
        </a>

        <a href="{{ route('customer.catalog.index') }}" class="block py-2 text-gray-700 font-medium">
            Katalog
        </a>

         <a href="{{ route('customer.artikel.carasewa') }}" 
        class="{{ $linkClass }} {{ request()->routeIs('customer.carasewa') ? $activeC : $inactiveC }}">
            Cara Sewa
        </a>

        <a href="{{ route('customer.rentals.history') }}" class="block py-2 text-gray-700 font-medium">
            Pesanan Saya
        </a>


        <!-- Tambahan edit profil di mobile -->
        <a href="{{ route('customer.profile.edit') }}" class="block py-2 text-gray-700 font-medium">
            Edit Profil
        </a>

        <!-- Bagian profil + logout -->
        <div class="border-t pt-2 mt-2">
            <div class="flex items-center gap-2 mb-3">
                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}" 
                     class="w-8 h-8 rounded-full">
                <span class="font-bold text-gray-800">{{ Auth::user()->name }}</span>
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="text-red-600 font-bold w-full text-left">
                    Keluar
                </button>
            </form>
        </div>
    </div>

</nav>
