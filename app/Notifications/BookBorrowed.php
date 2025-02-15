<?php

namespace App\Notifications;

use App\Models\Book;
use App\Models\BookLoan;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BookBorrowed extends Notification
{
    use Queueable;

    public $book;
    public $loan;

    public function __construct(Book $book, BookLoan $loan)
    {
        $this->book = $book;
        $this->loan = $loan;
    }

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toDatabase($notifiable): array
    {
        return [
            'message' => 'You have borrowed "' . $this->book->title . '"',
            'book_id' => $this->book->id,
            'loan_id' => $this->loan->id,
            'due_date' => $this->loan->due_date,
            'type' => 'book_borrowed',
            'url' => route('books.show', $this->book)
        ];
    }

    public function toArray($notifiable): array
    {
        return [
            'message' => 'You have borrowed "' . $this->book->title . '"',
            'book_id' => $this->book->id,
            'loan_id' => $this->loan->id,
            'due_date' => $this->loan->due_date,
            'type' => 'book_borrowed',
            'url' => route('books.show', $this->book)
        ];
    }
}
