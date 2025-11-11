<?php

namespace App\Mail;

use App\Models\DataRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DataRequestRejected extends Mailable 
{
    use Queueable, SerializesModels;

    public $dataRequest;

    public function __construct(DataRequest $dataRequest)
    {
        $this->dataRequest = $dataRequest;
    }

    public function build()
    {
        return $this->subject('Your Data Request Status - Disease Surveillance System')
            ->view('emails.data-request-rejected') 
            ->with([
                'dataRequest' => $this->dataRequest,
            ]);
    }
}