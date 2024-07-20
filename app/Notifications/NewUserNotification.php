<?php

namespace App\Notifications;

use App\Models\User;
use Ichtrojan\Otp\Otp;
use App\Models\Pharmacy;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NewUserNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $user;

    /**
     * Create a new notification instance.
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $otp = (new Otp)->generate(
            $this->user->email,
            config('pharmacy.otp.TYPE'),
            config('pharmacy.otp.LENGTH'),
            config('pharmacy.otp.VALID')
        )->token;
        $otpValidity = config('pharmacy.otp.VALID');
        $logoUrl = Pharmacy::find(1)->getFirstMediaUrl('pharmacyLogo');
        return (new MailMessage)
            ->view('emails.sendOTP', [
                'name' => $this->user->name,
                'otp' => $otp,
                'valid' => $otpValidity,
                'logoUrl' => $logoUrl,
            ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
