<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LoyaltyReward extends Notification
{
    use Queueable;

    public $customer;

    /**
     * Create a new notification instance.
     *
     * @param  \App\Models\Customer  $customer
     * @return void
     */
    public function __construct($customer)
    {
        $this->customer = $customer;
    }

    /**
     * Get the notification's mail representation.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Félicitations ! Vous avez une récompense ')
            ->greeting('Bonjour ' . $notifiable->name . ',')
            ->line('Vous avez atteint 500 points de fidélité !')
            ->line('Utilisez vos points pour obtenir des réductions spéciales.')
            ->action('Voir mes points', url('/customer/' . $notifiable->id . '/points'))
            ->line('Merci pour votre fidélité !');
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
            'customer_name' => $this->customer->name,
            'message' => 'Vous avez atteint 500 points de fidélité, félicitations !',
        ];
    }
}
