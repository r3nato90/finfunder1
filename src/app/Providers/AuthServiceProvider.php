<?php

namespace App\Providers;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Notifications\Messages\MailMessage;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];


    /**
     * @return void
     */
    public function boot(): void
    {
        VerifyEmail::toMailUsing(function (object $notifiable, string $url) {
            return (new MailMessage())
                ->subject('Verify Email Address')
                ->line('Click the button below to verify your email address.')
                ->action('Verify Email Address', $url);
        });

        ResetPassword::toMailUsing(function (object $notifiable, string $token) {
            return (new MailMessage)
                ->subject('Reset Password Notification')
                ->line('Hello!')
                ->line('You are receiving this email because we received a password reset request for your accounts.')
                ->action('Reset Password', url(config('app.url').route('password.reset', $token, false)))
                ->line('This password reset link will expire in 60 minutes.')
                ->line('If you did not request a password reset, no further action is required.')
                ->line('Regards');
        });
    }
}
