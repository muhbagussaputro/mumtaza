/**
 * SweetAlert Helper Functions
 * Universal helper untuk semua fungsi SweetAlert di aplikasi
 */

// Konfigurasi default SweetAlert
const defaultConfig = {
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Ya, Lanjutkan!',
    cancelButtonText: 'Batal'
};

/**
 * Menampilkan alert sukses
 * @param {string} title - Judul alert
 * @param {string} text - Teks pesan (optional)
 */
function showSuccess(title, text = '') {
    Swal.fire({
        icon: 'success',
        title: title,
        text: text,
        confirmButtonColor: defaultConfig.confirmButtonColor
    });
}

/**
 * Menampilkan alert error
 * @param {string} title - Judul alert
 * @param {string} text - Teks pesan (optional)
 */
function showError(title, text = '') {
    Swal.fire({
        icon: 'error',
        title: title,
        text: text,
        confirmButtonColor: defaultConfig.confirmButtonColor
    });
}

/**
 * Menampilkan alert warning
 * @param {string} title - Judul alert
 * @param {string} text - Teks pesan (optional)
 */
function showWarning(title, text = '') {
    Swal.fire({
        icon: 'warning',
        title: title,
        text: text,
        confirmButtonColor: defaultConfig.confirmButtonColor
    });
}

/**
 * Menampilkan alert info
 * @param {string} title - Judul alert
 * @param {string} text - Teks pesan (optional)
 */
function showInfo(title, text = '') {
    Swal.fire({
        icon: 'info',
        title: title,
        text: text,
        confirmButtonColor: defaultConfig.confirmButtonColor
    });
}

/**
 * Menampilkan konfirmasi delete
 * @param {string} title - Judul konfirmasi
 * @param {string} text - Teks pesan
 * @param {function} callback - Fungsi yang dijalankan jika dikonfirmasi (optional)
 * @returns {Promise} - Promise dari SweetAlert
 */
function confirmDelete(title = 'Apakah Anda yakin?', text = 'Data yang dihapus tidak dapat dikembalikan!', callback) {
    const swalPromise = Swal.fire({
        title: title,
        text: text,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: defaultConfig.cancelButtonColor,
        cancelButtonColor: defaultConfig.confirmButtonColor,
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: defaultConfig.cancelButtonText
    });

    // Jika callback diberikan, jalankan seperti sebelumnya untuk backward compatibility
    if (typeof callback === 'function') {
        swalPromise.then((result) => {
            if (result.isConfirmed) {
                callback();
            }
        });
    }

    // Selalu return promise untuk penggunaan modern
    return swalPromise;
}

/**
 * Menampilkan konfirmasi custom
 * @param {string} title - Judul konfirmasi
 * @param {string} text - Teks pesan
 * @param {function} callback - Fungsi yang dijalankan jika dikonfirmasi
 * @param {string} confirmText - Teks tombol konfirmasi (optional)
 */
function confirmAction(title, text, callback, confirmText = defaultConfig.confirmButtonText) {
    const swalPromise = Swal.fire({
        title: title,
        text: text,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: defaultConfig.confirmButtonColor,
        cancelButtonColor: defaultConfig.cancelButtonColor,
        confirmButtonText: confirmText,
        cancelButtonText: defaultConfig.cancelButtonText
    });

    if (typeof callback === 'function') {
        swalPromise.then((result) => {
            if (result.isConfirmed) {
                callback();
            }
        });
    }

    return swalPromise;
}

/**
 * Universal delete handler untuk form submission
 * @param {string} selector - CSS selector untuk delete buttons
 * @param {object} options - Opsi konfigurasi
 */
function initDeleteHandlers(selector = '.delete-btn', options = {}) {
    const defaultOptions = {
        titleAttribute: 'data-title',
        nameAttribute: 'data-name',
        formSelector: '.delete-form',
        confirmTitle: 'Apakah Anda yakin?',
        confirmText: 'Data yang dihapus tidak dapat dikembalikan!',
        loadingText: 'Menghapus data...'
    };
    
    const config = { ...defaultOptions, ...options };
    
    document.querySelectorAll(selector).forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            
            const form = this.closest(config.formSelector) || this.closest('form');
            const itemName = this.getAttribute(config.nameAttribute) || 'item ini';
            const customTitle = this.getAttribute(config.titleAttribute);
            
            const title = customTitle || config.confirmTitle;
            const text = `${config.confirmText} ${itemName ? `"${itemName}"` : ''}`;
            
            confirmDelete(title, text).then((result) => {
                if (result.isConfirmed && form) {
                    showLoading(config.loadingText);
                    form.submit();
                }
            });
        });
    });
}

/**
 * Menampilkan loading alert
 * @param {string} title - Judul loading
 * @param {string} text - Teks pesan (optional)
 */
function showLoading(title = 'Memproses...', text = 'Mohon tunggu sebentar') {
    Swal.fire({
        title: title,
        text: text,
        allowOutsideClick: false,
        allowEscapeKey: false,
        showConfirmButton: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });
}

/**
 * Menutup loading alert
 */
function hideLoading() {
    Swal.close();
}

/**
 * Menampilkan toast notification
 * @param {string} icon - Icon toast (success, error, warning, info)
 * @param {string} title - Judul toast
 * @param {string} position - Posisi toast (optional)
 */
function showToast(icon, title, position = 'top-end') {
    const Toast = Swal.mixin({
        toast: true,
        position: position,
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer);
            toast.addEventListener('mouseleave', Swal.resumeTimer);
        }
    });

    Toast.fire({
        icon: icon,
        title: title
    });
}

/**
 * Handle response dari AJAX request
 * @param {object} response - Response dari server
 */
function handleAjaxResponse(response) {
    if (response.success) {
        showToast('success', response.message || 'Operasi berhasil!');
    } else {
        showToast('error', response.message || 'Terjadi kesalahan!');
    }
}

/**
 * Handle error dari AJAX request
 * @param {object} xhr - XMLHttpRequest object
 */
function handleAjaxError(xhr) {
    let message = 'Terjadi kesalahan pada server!';
    
    if (xhr.responseJSON && xhr.responseJSON.message) {
        message = xhr.responseJSON.message;
    } else if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
        // Handle validation errors
        const errors = xhr.responseJSON.errors;
        const errorMessages = Object.values(errors).flat();
        message = errorMessages.join('\n');
    } else if (xhr.status === 404) {
        message = 'Data tidak ditemukan!';
    } else if (xhr.status === 403) {
        message = 'Anda tidak memiliki akses untuk melakukan operasi ini!';
    } else if (xhr.status === 500) {
        message = 'Terjadi kesalahan pada server!';
    }
    
    showError('Error', message);
}

// Export functions ke global scope
window.SweetAlertHelper = {
    showSuccess,
    showError,
    showWarning,
    showInfo,
    confirmDelete,
    confirmAction,
    initDeleteHandlers,
    showLoading,
    hideLoading,
    showToast,
    handleAjaxResponse,
    handleAjaxError
};

// Event listeners untuk toggle status guru
document.addEventListener('DOMContentLoaded', function() {
    // Toggle Status Guru
    document.querySelectorAll('.toggle-status-btn').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-toggle-status');
            const currentStatus = this.getAttribute('data-current-status');
            const statusText = currentStatus === 'active' ? 'nonaktifkan' : 'aktifkan';
            
            Swal.fire({
                title: 'Konfirmasi',
                text: 'Apakah Anda yakin ingin ' + statusText + ' guru ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, ' + statusText + '!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch('/admin/gurus/' + id + '/toggle-status', {
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

    // Delete Guru
    document.querySelectorAll('.delete-guru-btn').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-delete-guru');
            const nama = this.getAttribute('data-guru-nama');
            
            Swal.fire({
                title: 'Konfirmasi Hapus',
                text: 'Apakah Anda yakin ingin menghapus guru ' + nama + '?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch('/admin/gurus/' + id, {
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
});

// Show session messages dan auto-initialize delete handlers
document.addEventListener('DOMContentLoaded', function() {
    // Show success message dari window variable atau meta tag
    if (typeof window.sessionSuccess !== 'undefined' && window.sessionSuccess) {
        showSuccess('Berhasil!', window.sessionSuccess);
    } else {
        // Check meta tag untuk Laravel session
        const successMeta = document.querySelector('meta[name="session-success"]');
        if (successMeta && successMeta.content) {
            showSuccess('Berhasil!', successMeta.content);
        }
    }
    
    // Show error message dari window variable atau meta tag
    if (typeof window.sessionError !== 'undefined' && window.sessionError) {
        showError('Error!', window.sessionError);
    } else {
        // Check meta tag untuk Laravel session
        const errorMeta = document.querySelector('meta[name="session-error"]');
        if (errorMeta && errorMeta.content) {
            showError('Error!', errorMeta.content);
        }
    }
    
    // Auto-initialize delete handlers untuk semua tombol delete
    initDeleteHandlers('.delete-btn');
    initDeleteHandlers('.btn-delete');
    initDeleteHandlers('[data-action="delete"]');
});