<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class Offer extends Notification
{
    use Queueable;
    private $type;
    private $offer_id;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($offer_id,$type)
    {
        $this->offer_id = $offer_id;
        $this->type = $type;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];

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
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
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
            'id' => $this->offer_id,
            'text' =>__('admin/app.new_accept_offer'),
            'type' => $this->type,

        ];
    }

    public function toDatabase($notifiable)
    {
        return [
            'id' => $this->offer_id,
            'text' =>__('admin/app.new_accept_offer'),
            'type' => $this->type,

        ];
    }
}
