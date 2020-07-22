<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderShipped extends Mailable
{
  use Queueable, SerializesModels;

  /**
   * The order instance.
   *
   * @var Order
   */
  protected $order;

  /**
   * Create a new message instance.
   *
   * @return void
   */
  public function __construct(Order $order)
  {
    $this->order = $order;
  }

  /**
   * Build the message.
   *
   * @return $this
   */
  public function build()
  {
    $address = 'cskh@hotro.wesports.vn';
    $name = 'WeSports';
    $subject = 'Đơn hàng: '. $this->order->code . ". Ở WeSports";
    return $this->view('emails.mail')->from($address, $name)->subject($subject)->with(['order' => $this->order]);;
  }
}
