<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AqiAlertNotification extends Notification
{
    use Queueable;

    public $subject, $messages, $aqimessages;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(string $subject, array $messages, array $aqimessages = [])
    {
        $this->subject = $subject;
        $this->messages = $messages;
        $this->aqimessages = $aqimessages;
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
        foreach ($this->aqimessages as $key => $aqimessage) {
            $mailable->line($aqimessage);
        }

        return $mailable->action('View Dashboard', config('app.url'));
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
