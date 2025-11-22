<nav class="bg-gradient-to-r from-green-700 via-green-600 to-teal-600 shadow-lg sticky top-0 z-50">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center py-4">
            <!-- Logo & Brand -->
            <div class="flex items-center space-x-8">
                <a class="flex items-center space-x-3 text-white hover:text-green-100 transition" href="{{ url('/') }}">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    <span class="text-xl font-bold">{{ config('app.name', 'Outdoor Rental') }}</span>
                </a>
                
                <!-- Navigation Links -->
                <div class="hidden md:flex items-center space-x-6">
                    <a class="text-white hover:text-green-100 font-medium transition flex items-center" href="{{ route('catalog.index') }}">
                        <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                        {{ __('Catalog') }}
                    </a>
                    @auth
                        @if(Auth::user()->is_admin)
                            <a class="text-white hover:text-green-100 font-medium transition flex items-center" href="{{ route('admin.items.index') }}">
                                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                {{ __('Admin') }}
                            </a>
                        @endif
                    @endauth
                </div>
            </div>

            <!-- Right Side Menu -->
            <div class="flex items-center space-x-4">
                @guest
                    @if (Route::has('login'))
                        <a class="text-white hover:text-green-100 font-medium transition px-4 py-2 rounded-lg hover:bg-white/10" href="{{ route('login') }}">
                            {{ __('Login') }}
                        </a>
                    @endif

                    @if (Route::has('register'))
                        <a class="bg-white text-green-700 hover:bg-green-50 font-bold px-6 py-2 rounded-lg transition shadow-md hover:shadow-lg" href="{{ route('register') }}">
                            {{ __('Register') }}
                        </a>
                    @endif
                @else
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center space-x-2 bg-white/10 px-4 py-2 rounded-lg">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            <span class="text-white font-medium">{{ Auth::user()->name }}</span>
                        </div>
                        <a class="text-white hover:text-red-200 font-medium transition flex items-center" href="{{ route('logout') }}"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                            {{ __('Logout') }}
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                            @csrf
                        </form>
                    </div>
                @endguest
            </div>
        </div>
    </div>
</nav>