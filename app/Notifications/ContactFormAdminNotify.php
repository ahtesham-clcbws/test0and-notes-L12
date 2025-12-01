<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ContactFormAdminNotify extends Notification
{
    use Queueable;

    public $contactName = '';
    public $contactEmail = '';
    public $contactSubject = '';
    public $contactMessage = '';

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(
        $contactObject
    ) {
        $this->contactName = $contactObject->name;
        $this->contactEmail = $contactObject->email;
        $this->contactSubject = $contactObject->subject;
        $this->contactMessage = $contactObject->message;
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
        return (new MailMessage)
            ->subject("You\'ve got new contact submition")
            ->replyTo($this->contactEmail)
            ->greeting('Hi, Admin')
            ->line("Contact details below:")
            ->line('')
            ->line('Name: ' . $this->contactName)
            ->line('Email: ' . $this->contactEmail)
            ->line('Subject: ' . $this->contactSubject)
            ->line('Message: ' . $this->contactMessage);
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
