<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class OrderCreatedNotification extends Notification
{
    use Queueable;

    protected $order;
    /**
     * Create a new notification instance.
     */
    public function __construct( $order)
    {
        $this->order=$order;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
public function via($notifiable)
{
    return ['mail'];

    // $channels = ['database'];
    // if ($notifiable->notification_preferences['order_created']['sms'] ?? false) {
    //     $channels[] = 'vonage';
    // }

    // if ($notifiable->notification_preferences['order_created']['mail'] ?? false) {
    //     $channels[] = 'mail';
    // }

    // if ($notifiable->notification_preferences['order_created']['broadcast'] ?? false) {
    //     $channels[] = 'broadcast';
    // }

    // return $channels;
}


    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
            Log::info('Sending OrderCreatedNotification', [
        'order_id' => $this->order->id,
        'to' => $notifiable->email,
    ]);
        $addr=$this->order->billingAddress;
        return (new MailMessage)
            ->subject("New Order #{{$this->order->number}}")
            ->from('no-reply@multi-store.com','multi-vendor-store')
            ->greeting("Hi {$notifiable->name},")
            ->line("new order (#{{$this->order->number}}) created by {$addr->name} from {$addr->country_name}.")
            ->action('View Order', url('/dashboard'))
            ->line('Thank you for using our application!');
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
