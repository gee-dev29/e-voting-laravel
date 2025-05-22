<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OTPMail extends Mailable
{
  use Queueable, SerializesModels;

  public string $otp;

  /**
   * Create a new message instance.
   */
  public function __construct(string $otp)
  {
    $this->otp = $otp;
  }

  /**
   * Build the message.
   */
  public function build()
  {
    return $this->subject('Your OTP Code')
      ->view('emails.otp');
  }
}
