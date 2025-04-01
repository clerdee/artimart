<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Queue\SerializesModels;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */

    public $order;
    public $cart;
    public $shipping;
    public $customer;

    protected $pdfContent;

    public function __construct($order, $cart, $shipping, $customer)
    {
        $this->order = $order;
        $this->cart = $cart;
        $this->shipping = $shipping;
        $this->customer = $customer;
        

        $cartTotal = collect($this->cart->items)->reduce(function ($carry, $item) {
            return $carry + ($item['qty'] * $item['item']['sell_price']);
        }, 0);
        $orderTotal = number_format($cartTotal + $this->shipping->rate, 2);
        
        $this->pdfContent = Pdf::loadView('email.order_receipt', [
            'order' => $this->order,
            'cart' => $this->cart,
            'shipping' => $this->shipping,
            'cartTotal' => number_format($cartTotal, 2),
            'orderTotal' => $orderTotal,
            'customer' => $customer,
        ])->output();
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('noreply@plushit.test', 'Plush-IT'),
            subject: 'Your Order Receipt from Plush-IT',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $cartTotal = collect($this->cart->items)->reduce(function ($carry, $item) {
            return $carry + ($item['qty'] * $item['item']['sell_price']);
        }, 0);
    
        $orderTotal = number_format($cartTotal + $this->shipping->rate, 2);
        
        return new Content(
            view: 'email.order_receipt',
            with: [
                'order' => $this->order,
                'cart' => $this->cart,
                'shipping' => $this->shipping,
                'cartTotal' => number_format($cartTotal, 2), 
                'orderTotal' => $orderTotal,
                'customer' => $this->customer,
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [
            Attachment::fromData(fn () => $this->pdfContent, 'Order_Receipt.pdf')
                ->withMime('application/pdf'),
        ];
    }
}
