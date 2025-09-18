// Event listeners untuk siswa
document.addEventListener('DOMContentLoaded', function() {
    // Toggle Status Siswa
    document.querySelectorAll('.toggle-status-siswa-btn').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-toggle-status-siswa');
            const currentStatus = this.getAttribute('data-current-status');
            const statusText = currentStatus === 'active' ? 'nonaktifkan' : 'aktifkan';
            
            Swal.fire({
                title: 'Konfirmasi',
                text: 'Apakah Anda yakin ingin ' + statusText + ' siswa ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, ' + statusText + '!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch('/admin/siswas/' + id + '/toggle-status', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire('Berhasil!', data.message, 'success').then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire('Error!', data.message, 'error');
                        }
                    })
                    .catch(error => {
                        Swal.fire('Error!', 'Terjadi kesalahan sistem', 'error');
                    });
                }
            });
        });
    });

    // Graduate Siswa
    document.querySelectorAll('.graduate-siswa-btn').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-graduate-siswa');
            const nama = this.getAttribute('data-siswa-nama');
            
            Swal.fire({
                title: 'Konfirmasi Kelulusan',
                text: 'Apakah Anda yakin ingin meluluskan siswa ' + nama + '?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#10b981',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Luluskan!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch('/admin/siswas/' + id + '/graduate', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire('Berhasil!', data.message, 'success').then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire('Error!', data.message, 'error');
                        }
                    })
                    .catch(error => {
                        Swal.fire('Error!', 'Terjadi kesalahan sistem', 'error');
                    });
                }
            });
        });
    });

    // Delete Siswa
    document.querySelectorAll('.delete-siswa-btn').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-delete-siswa');
            const nama = this.getAttribute('data-siswa-nama');
            
            Swal.fire({
                title: 'Konfirmasi Hapus',
                text: 'Apakah Anda yakin ingin menghapus siswa ' + nama + '?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch('/admin/siswas/' + id, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire('Berhasil!', data.message, 'success').then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire('Error!', data.message, 'error');
                        }
                    })
                    .catch(error => {
                        Swal.fire('Error!', 'Terjadi kesalahan sistem', 'error');
                    });
                }
            });
        });
    });

    // Show session messages
    if (typeof sessionMessage !== 'undefined' && sessionMessage) {
        Swal.fire({
            title: sessionMessage.type === 'success' ? 'Berhasil!' : 'Informasi',
            text: sessionMessage.message,
            icon: sessionMessage.type,
            timer: 3000,
            showConfirmButton: false
        });
    }
});