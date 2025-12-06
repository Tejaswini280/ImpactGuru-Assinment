<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewOrderNotification extends Notification
{
    use Queueable;

    protected $order;

    /**
     * Create a new notification instance.
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject('New Order Created: ' . $this->order->order_number)
                    ->greeting('Hello ' . $notifiable->name . '!')
                    ->line('A new order has been created.')
                    ->line('Order Number: ' . $this->order->order_number)
                    ->line('Customer: ' . $this->order->customer->name)
                    ->line('Amount: $' . number_format($this->order->amount, 2))
                    ->line('Status: ' . ucfirst($this->order->status))
                    ->action('View Order', url('/orders/' . $this->order->id))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'order_id' => $this->order->id,
            'order_number' => $this->order->order_number,
            'customer_name' => $this->order->customer->name,
            'amount' => $this->order->amount,
            'status' => $this->order->status,
        ];
    }
}