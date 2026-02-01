<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RegistrationConfirmEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    //public $details;
    
    //public function __construct($details){
        
    public function __construct(){
        
        //$this->details = $details;
    
    }


    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Registration Confirmation for NDUB 2nd Convocation 2025',
        );
    }


    public function build(){
       return $this->subject('Registration Confirmation for NDUB 2nd Convocation 2025')
       ->view('emails.registration-confirmation');
    }
    

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.registration-confirmation');
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
    //
    
    /**
     * Build the message.
     *
     * @return $this
     */
    /*public function build(){

       return $this->markdown('mails.registration-confirmation' , [
            'details' => $this->details
        ]);
    }*/
    
}
