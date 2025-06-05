<?php

namespace App\Mail;

use App\Models\CommissionRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CommissionRejected extends Mailable
{
    use Queueable, SerializesModels;

    public $commission;

    public function __construct(CommissionRequest $commission)
    {
        $this->commission = $commission;
    }

    public function build()
    {
        return $this->view('emails.commission_rejected')
                    ->subject('Your Commission Request Has Been Rejected')
                    ->with([
                        'customerName' => $this->commission->customer->name,
                        'commissionTitle' => $this->commission->title,
                    ]);
    }
}
