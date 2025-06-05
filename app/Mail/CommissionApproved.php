<?php

namespace App\Mail;

use App\Models\CommissionRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CommissionApproved extends Mailable
{
    use Queueable, SerializesModels;

    public $commission;

    public function __construct(CommissionRequest $commission)
    {
        $this->commission = $commission;
    }

    public function build()
    {
        return $this->view('emails.commission_approved')
                    ->subject('Your Commission Request Has Been Approved!')
                    ->with([
                        'customerName' => $this->commission->customer->name,
                        'commissionTitle' => $this->commission->title,
                    ]);
    }
}
