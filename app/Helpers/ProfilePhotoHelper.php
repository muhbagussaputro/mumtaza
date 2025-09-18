<?php

namespace App\Helpers;

use Illuminate\Http\UploadedFile;

class ProfilePhotoHelper
{
    /**
     * Upload foto profil
     */
    public static function uploadPhoto(UploadedFile $file, ?string $oldPhotoPath = null, string $directory = 'profile-photos'): string
    {
        // Validasi ukuran file (maksimal 2MB)
        if ($file->getSize() > 2 * 1024 * 1024) {
            throw new \InvalidArgumentException('Ukuran file tidak boleh lebih dari 2MB');
        }

        // Validasi tipe file
        $allowedMimes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
        if (! in_array($file->getMimeType(), $allowedMimes)) {
            throw new \InvalidArgumentException('File harus berupa gambar (JPEG, PNG, JPG, GIF)');
        }

        // Hapus foto lama jika ada
        if ($oldPhotoPath) {
            self::deletePhoto($oldPhotoPath);
        }

        // Pastikan direktori ada
        self::ensureDirectoryExists($directory);

        // Generate nama file unik
        $fileName = time().'_'.uniqid().'.'.$file->getClientOriginalExtension();
        $filePath = $directory.'/'.$fileName;

        // Pindahkan file ke direktori tujuan
        $file->move(public_path($directory), $fileName);

        return $filePath;
    }

    /**
     * Hapus foto profil
     */
    public static function deletePhoto(string $photoPath): bool
    {
        if (! $photoPath) {
            return false;
        }

        $fullPath = public_path($photoPath);

        if (file_exists($fullPath)) {
            return unlink($fullPath);
        }

        return false;
    }

    /**
     * Get URL foto profil
     */
    public static function getPhotoUrl(?string $photoPath, string $defaultPhoto = 'images/default-avatar.png'): string
    {
        if (! $photoPath) {
            return asset($defaultPhoto);
        }

        $fullPath = public_path($photoPath);

        if (file_exists($fullPath)) {
            return asset($photoPath);
        }

        return asset($defaultPhoto);
    }

    /**
     * Validasi file upload
     */
    public static function validateFile(UploadedFile $file): array
    {
        $errors = [];

        // Validasi ukuran file (maksimal 2MB)
        if ($file->getSize() > 2 * 1024 * 1024) {
            $errors[] = 'Ukuran file tidak boleh lebih dari 2MB';
        }

        // Validasi tipe file
        $allowedMimes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
        if (! in_array($file->getMimeType(), $allowedMimes)) {
            $errors[] = 'File harus berupa gambar (JPEG, PNG, JPG, GIF)';
        }

        // Validasi dimensi minimum
        $imageInfo = getimagesize($file->getRealPath());
        if ($imageInfo && ($imageInfo[0] < 100 || $imageInfo[1] < 100)) {
            $errors[] = 'Dimensi gambar minimal 100x100 pixel';
        }

        return $errors;
    }

    /**
     * Create default avatar directory jika belum ada
     */
    public static function ensureDirectoryExists(string $directory = 'profile-photos'): void
    {
        $fullPath = public_path($directory);

        if (! file_exists($fullPath)) {
            mkdir($fullPath, 0755, true);
        }
    }

    /**
     * Get file size dalam format yang mudah dibaca
     */
    public static function formatFileSize(int $bytes): string
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        $bytes /= pow(1024, $pow);

        return round($bytes, 2).' '.$units[$pow];
    }
}
