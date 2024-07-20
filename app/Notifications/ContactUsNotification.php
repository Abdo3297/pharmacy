<?php

namespace App\Notifications;

use App\Models\User;
use App\Models\Pharmacy;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ContactUsNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $user;
    protected $data;

    /**
     * Create a new notification instance.
     */
    public function __construct(User $user, $data)
    {
        $this->user = $user;
        $this->data = $data;
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
        $logoUrl = Pharmacy::find(1)->getFirstMediaUrl('pharmacyLogo');
        return (new MailMessage)
            ->view('emails.contactUs', [
                'name' => $this->user->name,
                'email' => $this->user->email,
                'phone' => $this->user->phone,
                'complaintMessage' => $this->data['message'],
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
