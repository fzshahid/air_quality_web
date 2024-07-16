<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AqiAlertNotification extends Notification
{
    use Queueable;

    protected $subject, $messages;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(string $subject, array $messages)
    {
        $this->subject = $subject;
        $this->messages = $messages;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $mailable = (new MailMessage)
                    ->subject($this->subject);

        foreach ($this->messages as $key => $message) {
            $mailable->line($message);
        }        
        // ->action('Notification Action', url('/'))
        // ->line('Thank you for using our application');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
