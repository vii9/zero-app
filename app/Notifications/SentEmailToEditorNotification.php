<?php

namespace App\Notifications;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SentEmailToEditorNotification extends Notification
{
    use Queueable;

    protected $_product; // new product created


    /**
     * Create a new notification instance.
     *
     * @param Product $product
     */
    public function __construct(Product $product)
    {
        $this->_product = $product;
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
     * @param  mixed  $notifiable is info editor
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line(sprintf('Hello Editor %s and id %s', $notifiable->email, $notifiable->id))
            ->line(sprintf('product name: %s and id %s', $this->_product->name, $this->_product->id))
            ->action('link product detail', route('api.products.show', $this->_product->id))
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
            //
        ];
    }
}
