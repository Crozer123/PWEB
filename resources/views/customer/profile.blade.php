@extends('layouts.app')

@section('content')

<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <!-- HEADER SECTION -->
    <div class="mb-6">
        <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Pengaturan Profil</h1>
        <p class="text-gray-500 text-sm">Kelola informasi akun dan keamanan Anda.</p>
    </div>

    <!-- SUCCESS NOTIFICATION (SweetAlert2) -->
    @if(session('success'))
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '{{ session('success') }}',
                    confirmButtonColor: '#059669',
                    timer: 3000
                });
            });
        </script>
    @endif

    <!-- ERROR VALIDATION -->
    @if($errors->any())
        <div class="bg-red-50 text-red-600 p-4 rounded-xl mb-6 border border-red-100">
            <ul class="list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        <!-- LEFT SIDEBAR (Profile Summary) -->
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 text-center">
                <div class="relative inline-block">
                    <img 
                        id="avatarPreviewSide"
                        src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&background=059669&color=fff&size=128' }}"
                        class="w-32 h-32 rounded-full shadow-md object-cover border-4 border-emerald-50 mx-auto"
                    >
                </div>
                <h2 class="text-xl font-bold text-gray-800 mt-4">{{ Auth::user()->name }}</h2>
                <p class="text-emerald-600 font-medium text-sm">{{ Auth::user()->email }}</p>
                <div class="mt-4 inline-flex items-center px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 text-xs font-bold">
                    Customer
                </div>
            </div>
        </div>


        <!-- RIGHT SIDE: FORMS -->
        <div class="lg:col-span-2 space-y-8">


            <!-- FORM 1: UPDATE PROFILE INFO -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">

                <h3 class="text-lg font-bold text-gray-800 mb-6 flex items-center gap-2">
                    <i class="fa-solid fa-user-pen text-emerald-500"></i> Informasi Dasar
                </h3>

                <form action="{{ route('customer.profile.update') }}" 
                      method="POST" 
                      enctype="multipart/form-data"
                      class="space-y-6">
                    
                    @csrf
                    @method('PUT')

                    <!-- Profile Picture Upload -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Foto Profil</label>
                        <div class="flex items-center gap-4">
                            <img id="avatarPreviewForm" 
                                 src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&background=059669&color=fff' }}" 
                                 class="w-12 h-12 rounded-full object-cover">
                            
                            <input type="file" name="avatar" id="avatarInput"
                                class="block w-full text-sm text-gray-500
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-full file:border-0
                                file:text-xs file:font-semibold
                                file:bg-emerald-50 file:text-emerald-700
                                hover:file:bg-emerald-100 cursor-pointer">
                        </div>
                    </div>

                    <!-- Name & Email -->
                    <div class="grid md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-gray-700 font-medium text-sm">Nama Lengkap</label>
                            <input type="text" name="name" value="{{ old('name', Auth::user()->name) }}"
                                class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition">
                        </div>

                        <div class="space-y-2">
                            <label class="text-gray-700 font-medium text-sm">Alamat Email</label>
                            <input type="email" name="email" value="{{ old('email', Auth::user()->email) }}"
                                class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition">
                        </div>
                    </div>

                    <div class="pt-2 text-right">
                        <button type="submit"
                            class="px-6 py-2.5 bg-emerald-600 text-white rounded-xl font-semibold text-sm hover:bg-emerald-700 shadow-lg shadow-emerald-200 transition">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>


            <!-- FORM 2: UPDATE PASSWORD -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">

                <h3 class="text-lg font-bold text-gray-800 mb-6 flex items-center gap-2">
                    <i class="fa-solid fa-lock text-emerald-500"></i> Ganti Password
                </h3>

                <form action="{{ route('customer.password.update') }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="space-y-2">
                        <label class="text-gray-700 font-medium text-sm">Password Baru</label>
                        <input type="password" name="password" placeholder="Minimal 8 karakter"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition">
                    </div>

                    <div class="space-y-2">
                        <label class="text-gray-700 font-medium text-sm">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" placeholder="Ulangi password baru"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition">
                    </div>

                    <div class="pt-2 text-right">
                        <button type="submit"
                            class="px-6 py-2.5 bg-gray-800 text-white rounded-xl font-semibold text-sm hover:bg-gray-900 shadow-lg transition">
                            Update Password
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

<!-- IMAGE PREVIEW HANDLER -->
<script>
document.getElementById('avatarInput').addEventListener('change', function(e) {
    if(e.target.files.length > 0){
        let src = URL.createObjectURL(e.target.files[0]);
        document.getElementById('avatarPreviewForm').src = src;
        document.getElementById('avatarPreviewSide').src = src;
    }
});
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@endsection
