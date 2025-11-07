<?php

namespace App\Mail;

use App\Models\DataRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DataRequestApproved extends Mailable 
{
    use Queueable, SerializesModels;

    public $dataRequest;
    public $pdfPath;

    /**
     * Create a new message instance.
     */
    public function __construct(DataRequest $dataRequest, $pdfPath = null)
    {
        $this->dataRequest = $dataRequest;
        $this->pdfPath = $pdfPath;
    }

    public function build()
    {
        $email = $this->subject('Your Data Request Has Been Approved - Disease Surveillance System')
            ->markdown('emails.data-request-approved')
            ->with([
                'dataRequest' => $this->dataRequest,
                'hasAttachment' => !is_null($this->pdfPath),
            ]);

        // Attach PDF if available
        if ($this->pdfPath && file_exists($this->pdfPath)) {
            $email->attach($this->pdfPath, [
                'as' => "data-request-report-{$this->dataRequest->id}.pdf",
                'mime' => 'application/pdf',
            ]);
        }

        return $email;
    }
}