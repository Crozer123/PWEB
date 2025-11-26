<footer class="bg-gradient-to-r from-gray-900 via-gray-800 to-gray-900 text-white mt-auto print:hidden">
    <div class="container mx-auto px-4 py-12">
        {{-- Grid tetap 4 kolom agar ukuran konsisten --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">

            <div>
                <div class="flex items-center space-x-2 mb-4">
                    <svg class="w-8 h-8 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    <h3 class="text-xl font-bold">Forest Adventure</h3>
                </div>
                <p class="text-gray-400 text-sm leading-relaxed mb-4">
                    Partner terpercaya untuk petualangan alam Anda. Jelajahi alam dengan perlengkapan terbaik.
                </p>
            </div>

            {{-- TAMBAHKAN: md:col-start-4 --}}
            {{-- OPSI TAMBAHAN: md:text-right (jika ingin teksnya rata kanan juga) --}}
            <div class="md:col-start-4"> 
                <h4 class="text-lg font-bold mb-4 text-green-400">Kontak</h4>
                <ul class="space-y-3 text-sm text-gray-400">
                    <li>123 Adventure Street, Indonesia</li>
                    <li>info@forestadventure.com</li>
                    <li>+62 838 6963 4931</li>
                </ul>
            </div>
            
        </div>

        <div class="border-t border-gray-700 mt-8 pt-8 text-center md:text-left flex flex-col md:flex-row justify-between">
            <p class="text-gray-400 text-sm">
                © {{ date('Y') }} Forest Adventure. All rights reserved.
            </p>
        </div>
    </div>
</footer>