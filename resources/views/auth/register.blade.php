@extends('layouts.app')

@section('content')
<div class="min-h-screen relative overflow-hidden py-12">

    <div class="absolute inset-0 z-0">
        <img src="https://images.unsplash.com/photo-1551632811-561732d1e306?w=1920" 
             alt="Outdoor Adventure" 
             class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-br from-teal-900/80 via-green-900/70 to-gray-900/80"></div>

        <div class="absolute top-32 right-20 animate-bounce">
            <svg class="w-20 h-20 text-white/10" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 2L3 7v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V7l-7-5z"/>
            </svg>
        </div>

        <div class="absolute bottom-20 left-10 animate-pulse">
            <svg class="w-16 h-16 text-white/20" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6z"/>
            </svg>
        </div>
    </div>

    <div class="container mx-auto px-4 relative z-10">
        <div class="flex justify-center items-center">
            <div class="w-full max-w-lg">

                <div class="text-center mb-8">
                    <div class="inline-block p-4 bg-white/10 backdrop-blur-sm rounded-full mb-4">
                        <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                        </svg>
                    </div>
                    <h1 class="text-4xl font-bold text-white mb-2">{{ __('Join Our Community') }}</h1>
                    <p class="text-teal-200 text-lg">{{ __('Start Your Adventure Today') }}</p>
                </div>

                <div class="bg-white/95 backdrop-blur-md shadow-2xl rounded-2xl overflow-hidden border border-white/20">

                    <div class="bg-gradient-to-r from-teal-600 via-green-500 to-green-600 px-8 py-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <h2 class="text-2xl font-bold text-white">{{ __('Create Account') }}</h2>
                                <p class="text-green-100 text-sm mt-1">{{ __('Get ready for your next adventure') }}</p>
                            </div>
                            <div class="bg-white/20 p-3 rounded-full">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="p-8">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="mb-5">
                                <label for="name" class="block text-gray-700 text-sm font-bold mb-2 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    {{ __('Full Name') }}
                                </label>
                                <div class="relative">
                                    <input id="name" type="text" 
                                        class="w-full px-4 py-3 pl-11 border-2 border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition @error('name') border-red-500 @enderror" 
                                        name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Rizqi Ramadhani">

                                    <div class="absolute left-3 top-3.5">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                    </div>
                                </div>

                                @error('name')
                                    <p class="text-red-500 text-sm mt-2 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div class="mb-5">
                                <label for="email" class="block text-gray-700 text-sm font-bold mb-2 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                    {{ __('Email Address') }}
                                </label>

                                <div class="relative">
                                    <input id="email" type="email"
                                        class="w-full px-4 py-3 pl-11 border-2 border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition @error('email') border-red-500 @enderror" 
                                        name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="your@email.com">

                                    <div class="absolute left-3 top-3.5">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                                        </svg>
                                    </div>
                                </div>

                                @error('email')
                                    <p class="text-red-500 text-sm mt-2 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div class="mb-5">
                                <label for="password" class="block text-gray-700 text-sm font-bold mb-2 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                    </svg>
                                    {{ __('Password') }}
                                </label>

                                <div class="relative">
                                    <input id="password" type="password"
                                        class="w-full px-4 py-3 pl-11 border-2 border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition @error('password') border-red-500 @enderror" 
                                        name="password" required autocomplete="new-password" placeholder="••••••••">

                                    <div class="absolute left-3 top-3.5">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                                        </svg>
                                    </div>
                                </div>

                                @error('password')
                                    <p class="text-red-500 text-sm mt-2 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div class="mb-6">
                                <label for="password-confirm" class="block text-gray-700 text-sm font-bold mb-2 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                    </svg>
                                    {{ __('Confirm Password') }}
                                </label>

                                <div class="relative">
                                    <input id="password-confirm" type="password"
                                        class="w-full px-4 py-3 pl-11 border-2 border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition" 
                                        name="password_confirmation" required autocomplete="new-password" placeholder="••••••••">

                                    <div class="absolute left-3 top-3.5">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-6">
                                <button type="submit"
                                    class="w-full bg-gradient-to-r from-teal-600 to-green-600 hover:from-teal-700 hover:to-green-700 text-white font-bold py-4 px-4 rounded-xl transition duration-300 ease-in-out transform hover:scale-[1.02] hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 flex items-center justify-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                                    </svg>
                                    {{ __('Create Account') }}
                                </button>
                            </div>

                            <div class="relative mb-6">
                                <div class="absolute inset-0 flex items-center">
                                    <div class="w-full border-t border-gray-300"></div>
                                </div>
                                <div class="relative flex justify-center text-sm">
                                    <span class="px-4 bg-white text-gray-500 font-medium">{{ __('Already a member?') }}</span>
                                </div>
                            </div>

                            <div class="text-center">
                                <a class="inline-flex items-center justify-center w-full bg-white border-2 border-green-600 text-green-600 hover:bg-green-50 font-bold py-3 px-4 rounded-xl transition duration-300 ease-in-out transform hover:scale-[1.02]" 
                                   href="{{ route('login') }}">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                                    </svg>
                                    {{ __('Login to Your Account') }}
                                </a>
                            </div>

                        </form>
                    </div>
                </div>

                <div class="mt-8 text-center">
                    <p class="text-white/80 text-sm flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                        {{ __('Your data is safe and secure with us') }}
                    </p>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
