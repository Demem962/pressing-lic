<?php

namespace App\Mail;

use App\Models\Ticket;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TicketReadyMail extends Mailable
{
    use Queueable, SerializesModels;

    public Ticket $ticket;

    public function __construct(Ticket $ticket)
    {
        $this->ticket = $ticket;
    }

    public function build()
    {
        $pdf = Pdf::loadView('pdf.ticket-receipt', ['ticket' => $this->ticket]);

        return $this->subject('Votre commande #' . $this->ticket->id . ' est prête')
            ->view('emails.ticket-ready')
            ->attachData($pdf->output(), 'recu-ticket-' . $this->ticket->id . '.pdf', [
                'mime' => 'application/pdf',
            ]);
    }
}
