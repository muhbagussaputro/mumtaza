@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-gradient-to-r from-teal-500 to-teal-600 text-white">
        <div class="px-4 py-6">
            <div class="flex items-center">
                <a href="{{ route('admin.users.index') }}" class="mr-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </a>
                <div>
                    <h1 class="text-xl font-bold">Edit User</h1>
                    <p class="text-teal-100 text-sm">Edit data pengguna {{ $user->name }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Form -->
    <div class="px-4 py-6">
        <div class="bg-white rounded-lg shadow-sm p-6">
            <form method="POST" action="{{ route('admin.users.update', $user->id) }}" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')
                
                <!-- Nama -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Lengkap <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="name" 
                           name="name" 
                           value="{{ old('name', $user->name) }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 @error('name') border-red-500 @enderror"
                           placeholder="Masukkan nama lengkap"
                           required>
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        Email <span class="text-red-500">*</span>
                    </label>
                    <input type="email" 
                           id="email" 
                           name="email" 
                           value="{{ old('email', $user->email) }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 @error('email') border-red-500 @enderror"
                           placeholder="Masukkan alamat email"
                           required>
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                        Password <small class="text-gray-500">(Kosongkan jika tidak ingin mengubah)</small>
                    </label>
                    <input type="password" 
                           id="password" 
                           name="password" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 @error('password') border-red-500 @enderror"
                           placeholder="Masukkan password baru">
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                        Konfirmasi Password
                    </label>
                    <input type="password" 
                           id="password_confirmation" 
                           name="password_confirmation" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
                           placeholder="Konfirmasi password baru">
                </div>

                <!-- Role -->
                <div>
                    <label for="role" class="block text-sm font-medium text-gray-700 mb-2">
                        Role <span class="text-red-500">*</span>
                    </label>
                    <select id="role" 
                            name="role" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 @error('role') border-red-500 @enderror"
                            required>
                        <option value="">Pilih Role</option>
                        <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="guru" {{ old('role', $user->role) == 'guru' ? 'selected' : '' }}>Guru</option>
                        <option value="siswa" {{ old('role', $user->role) == 'siswa' ? 'selected' : '' }}>Siswa</option>
                        <option value="orang_tua" {{ old('role', $user->role) == 'orang_tua' ? 'selected' : '' }}>Orang Tua</option>
                    </select>
                    @error('role')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- NIS (untuk siswa) -->
                <div id="nis-field" style="display: none;">
                    <label for="nis" class="block text-sm font-medium text-gray-700 mb-2">
                        NIS
                    </label>
                    <input type="text" 
                           id="nis" 
                           name="nis" 
                           value="{{ old('nis', $user->nis) }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 @error('nis') border-red-500 @enderror"
                           placeholder="Masukkan NIS">
                    @error('nis')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tanggal Lahir -->
                <div>
                    <label for="tanggal_lahir" class="block text-sm font-medium text-gray-700 mb-2">
                        Tanggal Lahir
                    </label>
                    <input type="date" 
                           id="tanggal_lahir" 
                           name="tanggal_lahir" 
                           value="{{ old('tanggal_lahir', $user->tanggal_lahir ? $user->tanggal_lahir->format('Y-m-d') : '') }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 @error('tanggal_lahir') border-red-500 @enderror">
                    @error('tanggal_lahir')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Jenis Kelamin -->
                <div>
                    <label for="jenis_kelamin" class="block text-sm font-medium text-gray-700 mb-2">
                        Jenis Kelamin
                    </label>
                    <select id="jenis_kelamin" 
                            name="jenis_kelamin" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 @error('jenis_kelamin') border-red-500 @enderror">
                        <option value="">Pilih Jenis Kelamin</option>
                        <option value="L" {{ old('jenis_kelamin', $user->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ old('jenis_kelamin', $user->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                    @error('jenis_kelamin')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Alamat -->
                <div>
                    <label for="alamat" class="block text-sm font-medium text-gray-700 mb-2">
                        Alamat
                    </label>
                    <textarea id="alamat" 
                              name="alamat" 
                              rows="3"
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 @error('alamat') border-red-500 @enderror"
                              placeholder="Masukkan alamat lengkap">{{ old('alamat', $user->alamat) }}</textarea>
                    @error('alamat')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- No Telepon -->
                <div>
                    <label for="no_telepon" class="block text-sm font-medium text-gray-700 mb-2">
                        No. Telepon
                    </label>
                    <input type="text" 
                           id="no_telepon" 
                           name="no_telepon" 
                           value="{{ old('no_telepon', $user->telepon) }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 @error('no_telepon') border-red-500 @enderror"
                           placeholder="Masukkan nomor telepon">
                    @error('no_telepon')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Nama Orang Tua (untuk siswa) -->
                <div id="parent-field" style="display: none;">
                    <label for="parent_name" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Orang Tua
                    </label>
                    <input type="text" 
                           id="parent_name" 
                           name="parent_name" 
                           value="{{ old('parent_name', $user->orang_tua_nama) }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 @error('parent_name') border-red-500 @enderror"
                           placeholder="Masukkan nama orang tua">
                    @error('parent_name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status Aktif -->
                <div>
                    <label class="flex items-center">
                        <input type="checkbox" 
                               name="status_aktif" 
                               value="1" 
                               {{ old('status_aktif', $user->status_aktif) ? 'checked' : '' }}
                               class="rounded border-gray-300 text-teal-600 shadow-sm focus:border-teal-300 focus:ring focus:ring-teal-200 focus:ring-opacity-50">
                        <span class="ml-2 text-sm text-gray-700">Status Aktif</span>
                    </label>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-3 pt-6 border-t border-gray-200">
                    <button type="submit" 
                            class="flex-1 bg-teal-600 text-white py-3 px-6 rounded-lg hover:bg-teal-700 focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 font-medium">
                        <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Update User
                    </button>
                    <a href="{{ route('admin.users.index') }}" 
                       class="flex-1 bg-gray-500 text-white py-3 px-6 rounded-lg hover:bg-gray-600 focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 font-medium text-center">
                        <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const roleSelect = document.getElementById('role');
    const nisField = document.getElementById('nis-field');
    const parentField = document.getElementById('parent-field');
    
    function toggleFields() {
        const selectedRole = roleSelect.value;
        
        if (selectedRole === 'siswa') {
            nisField.style.display = 'block';
            parentField.style.display = 'block';
        } else {
            nisField.style.display = 'none';
            parentField.style.display = 'none';
        }
    }
    
    roleSelect.addEventListener('change', toggleFields);
    toggleFields(); // Initial call
});
</script>

@if(session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Wait for SweetAlert2 helper to be loaded
        const checkAndShow = () => {
            if (typeof showSuccess !== 'undefined') {
                showSuccess('{{ session('success') }}');
            } else {
                setTimeout(checkAndShow, 100);
            }
        };
        checkAndShow();
    });
</script>
@endif

@if(session('error'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const checkAndShow = () => {
            if (typeof showError !== 'undefined') {
                showError('{{ session('error') }}');
            } else {
                setTimeout(checkAndShow, 100);
            }
        };
        checkAndShow();
    });
</script>
@endif

@if($errors->any())
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const checkAndShow = () => {
            if (typeof showError !== 'undefined') {
                showError('{{ $errors->first() }}');
            } else {
                setTimeout(checkAndShow, 100);
            }
        };
        checkAndShow();
    });
</script>
@endif
@endsection