<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Informasi Profil') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Perbarui informasi profil dan alamat email akun Anda.') }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Left Column -->
            <div class="space-y-4">
                <!-- Profile Photo -->
                <div class="space-y-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        {{ __('Foto Profil') }}
                    </label>
                    
                    <div class="flex items-center space-x-4">
                        <div class="flex-shrink-0">
                            @if ($user->foto_path)
                                <img id="current-photo" class="h-20 w-20 rounded-full object-cover border-2 border-gray-200"
                                    src="{{ asset('storage/' . $user->foto_path) }}" alt="{{ $user->name }}">
                            @else
                                <div id="current-photo"
                                    class="h-20 w-20 rounded-full bg-gradient-to-br from-teal-400 to-teal-600 flex items-center justify-center border-2 border-gray-200">
                                    <span class="text-2xl font-bold text-white">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </span>
                                </div>
                            @endif
                        </div>
                        
                        <div class="flex-1">
                            <div class="flex flex-col space-y-2">
                                <label for="profile_photo" class="cursor-pointer inline-flex items-center px-3 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    {{ __('Pilih Foto') }}
                                </label>
                                <input type="file" name="profile_photo" id="profile_photo" class="hidden" accept="image/*">
                                
                                @if ($user->foto_path)
                                    <form method="post" action="{{ route('profile.photo.delete') }}" class="inline">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="inline-flex items-center px-3 py-2 border border-red-300 rounded-md shadow-sm text-sm font-medium text-red-700 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus foto profil?')">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                            {{ __('Hapus Foto') }}
                                        </button>
                                    </form>
                                @endif
                            </div>
                            
                            <p class="mt-2 text-xs text-gray-500">
                                {{ __('Format: JPG, PNG, GIF maksimal 2MB') }}
                            </p>
                            @error('profile_photo')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    <!-- Photo Preview -->
                    <div id="photo-preview" class="hidden">
                        <img id="preview-image" class="h-20 w-20 rounded-full object-cover border-2 border-teal-200">
                        <p class="text-sm text-gray-600 mt-1">Preview foto baru</p>
                    </div>
                </div>

                <!-- Name -->
                <div>
                    <x-input-label for="name" :value="__('Nama Lengkap')" />
                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                        :value="old('name', $user->name)" required autofocus autocomplete="name" />
                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                </div>

                <!-- Email -->
                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" name="email" type="email" class="mt-1 block w-full"
                        :value="old('email', $user->email)" required autocomplete="username" />
                    <x-input-error class="mt-2" :messages="$errors->get('email')" />

                    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                        <div>
                            <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                                {{ __('Email Anda belum terverifikasi.') }}

                                <button form="send-verification"
                                    class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                                    {{ __('Klik di sini untuk mengirim ulang email verifikasi.') }}
                                </button>
                            </p>

                            @if (session('status') === 'verification-link-sent')
                                <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                                    {{ __('Tautan verifikasi baru telah dikirim ke alamat email Anda.') }}
                                </p>
                            @endif
                        </div>
                    @endif
                </div>
            </div>

            <!-- Right Column -->
            <div class="space-y-4">
                <!-- Phone -->
                <div>
                    <x-input-label for="telepon" :value="__('Nomor Telepon')" />
                    <x-text-input id="telepon" name="telepon" type="tel" class="mt-1 block w-full"
                        :value="old('telepon', $user->telepon)" autocomplete="tel" />
                    <x-input-error class="mt-2" :messages="$errors->get('telepon')" />
                </div>

                <!-- Birth Place -->
                <div>
                    <x-input-label for="tempat_lahir" :value="__('Tempat Lahir')" />
                    <x-text-input id="tempat_lahir" name="tempat_lahir" type="text" class="mt-1 block w-full"
                        :value="old('tempat_lahir', $user->tempat_lahir)" />
                    <x-input-error class="mt-2" :messages="$errors->get('tempat_lahir')" />
                </div>

                <!-- Birth Date -->
                <div>
                    <x-input-label for="tanggal_lahir" :value="__('Tanggal Lahir')" />
                    <x-text-input id="tanggal_lahir" name="tanggal_lahir" type="date" class="mt-1 block w-full"
                        :value="old('tanggal_lahir', $user->tanggal_lahir)" />
                    <x-input-error class="mt-2" :messages="$errors->get('tanggal_lahir')" />
                </div>

                <!-- Parent Name (for students) -->
                @if($user->role === 'siswa')
                <div>
                    <x-input-label for="orang_tua_nama" :value="__('Nama Orang Tua')" />
                    <x-text-input id="orang_tua_nama" name="orang_tua_nama" type="text" class="mt-1 block w-full"
                        :value="old('orang_tua_nama', $user->orang_tua_nama)" />
                    <x-input-error class="mt-2" :messages="$errors->get('orang_tua_nama')" />
                </div>
                @endif
            </div>
        </div>

        <!-- Address (Full Width) -->
        <div>
            <x-input-label for="alamat" :value="__('Alamat')" />
            <textarea id="alamat" name="alamat" rows="3"
                class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-teal-500 dark:focus:border-teal-600 focus:ring-teal-500 dark:focus:ring-teal-600 rounded-md shadow-sm"
                placeholder="Masukkan alamat lengkap...">{{ old('alamat', $user->alamat) }}</textarea>
            <x-input-error class="mt-2" :messages="$errors->get('alamat')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button class="bg-teal-600 hover:bg-teal-700 focus:bg-teal-700 active:bg-teal-900 focus:ring-teal-500">
                {{ __('Simpan Perubahan') }}
            </x-primary-button>

            @if (session('success'))
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)"
                    class="text-sm text-green-600 dark:text-green-400">{{ session('success') }}</p>
            @endif
        </div>
    </form>

    <script>
        // Photo preview functionality
        document.getElementById('profile_photo').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                // Validate file size (2MB)
                if (file.size > 2 * 1024 * 1024) {
                    alert('Ukuran file terlalu besar. Maksimal 2MB.');
                    e.target.value = '';
                    return;
                }
                
                // Validate file type
                const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
                if (!allowedTypes.includes(file.type)) {
                    alert('Format file tidak didukung. Gunakan JPG, PNG, atau GIF.');
                    e.target.value = '';
                    return;
                }
                
                // Show preview
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('preview-image').src = e.target.result;
                    document.getElementById('photo-preview').classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            } else {
                document.getElementById('photo-preview').classList.add('hidden');
            }
        });
    </script>
</section>
