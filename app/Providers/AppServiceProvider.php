<?php

namespace App\Providers;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Custom reset password email
        ResetPassword::createUrlUsing(function ($notifiable, $token) {
            return url(route('password.reset', [
                'token' => $token,
                'email' => $notifiable->getEmailForPasswordReset(),
            ], false));
        });

        ResetPassword::toMailUsing(function ($notifiable, $token) {
            $url = url(route('password.reset', [
                'token' => $token,
                'email' => $notifiable->getEmailForPasswordReset(),
            ], false));

            return (new MailMessage)
                ->subject('Atur Ulang Kata Sandi - '.config('app.name'))
                ->view('emails.auth.reset-password', [
                    'url' => $url,
                    'token' => $token,
                    'notifiable' => $notifiable,
                    'count' => config('auth.passwords.'.config('auth.defaults.passwords').'.expire'),
                ]);
        });
    }
}
