// SweetAlert2 Helper Functions
import Swal from 'sweetalert2';

// Success notification
export const showSuccess = (message, title = 'Berhasil!') => {
    return Swal.fire({
        icon: 'success',
        title: title,
        text: message,
        timer: 3000,
        showConfirmButton: false,
        toast: true,
        position: 'top-end',
        timerProgressBar: true
    });
};

// Error notification
export const showError = (message, title = 'Error!') => {
    return Swal.fire({
        icon: 'error',
        title: title,
        text: message,
        confirmButtonText: 'OK',
        confirmButtonColor: '#d33'
    });
};

// Warning notification
export const showWarning = (message, title = 'Peringatan!') => {
    return Swal.fire({
        icon: 'warning',
        title: title,
        text: message,
        confirmButtonText: 'OK',
        confirmButtonColor: '#f59e0b'
    });
};

// Info notification
export const showInfo = (message, title = 'Informasi') => {
    return Swal.fire({
        icon: 'info',
        title: title,
        text: message,
        confirmButtonText: 'OK',
        confirmButtonColor: '#3b82f6'
    });
};

// Confirm delete
export const confirmDelete = (message = 'Yakin ingin menghapus data ini?', title = 'Konfirmasi Hapus') => {
    return Swal.fire({
        title: title,
        text: message,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal',
        reverseButtons: true
    });
};

// Confirm action
export const confirmAction = (message, title = 'Konfirmasi', confirmText = 'Ya', cancelText = 'Batal') => {
    return Swal.fire({
        title: title,
        text: message,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#059669',
        cancelButtonColor: '#6b7280',
        confirmButtonText: confirmText,
        cancelButtonText: cancelText,
        reverseButtons: true
    });
};

// Loading
export const showLoading = (message = 'Memproses...') => {
    return Swal.fire({
        title: message,
        allowOutsideClick: false,
        allowEscapeKey: false,
        showConfirmButton: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });
};

// Close loading
export const closeLoading = () => {
    Swal.close();
};

// Toast notification
export const showToast = (message, icon = 'success', position = 'top-end') => {
    return Swal.fire({
        toast: true,
        position: position,
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        icon: icon,
        title: message
    });
};

// Make functions available globally
window.showSuccess = showSuccess;
window.showError = showError;
window.showWarning = showWarning;
window.showInfo = showInfo;
window.confirmDelete = confirmDelete;
window.confirmAction = confirmAction;
window.showLoading = showLoading;
window.closeLoading = closeLoading;
window.showToast = showToast;