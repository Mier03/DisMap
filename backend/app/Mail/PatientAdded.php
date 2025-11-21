<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PatientAdded extends Mailable 
{
    use Queueable, SerializesModels;

    public $patient;
    public $password;
    public $username;

    /**
     * Create a new message instance.
     */
    public function __construct($patient, $password = '12345678')
    {
        $this->patient = $patient;
        $this->password = $password;
        $this->username = $patient->username;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Welcome to Disease Surveillance System - Your Patient Account',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.patient-added',
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        return [];
    }
}