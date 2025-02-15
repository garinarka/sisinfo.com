<?php

namespace App\Notifications;

use App\Models\Book;
use App\Models\BookLoan;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BookReturned extends Notification implements ShouldQueue
{
    use Queueable;

    protected $book;
    protected $loan;

    public function __construct(Book $book, BookLoan $loan)
    {
        $this->book = $book;
        $this->loan = $loan;
    }

    public function via($notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Book Returned - ' . $this->book->title)
            ->line('You have returned the book: ' . $this->book->title)
            ->line('Return date: ' . $this->loan->returned_date->format('Y-m-d'))
            ->line('Thank you for using our library service!');
    }

    public function toArray($notifiable): array
    {
        return [
            'message' => 'You have returned "' . $this->book->title . '"',
            'book_id' => $this->book->id,
            'loan_id' => $this->loan->id,
            'returned_date' => $this->loan->returned_date,
            'type' => 'book_returned'
        ];
    }
}
