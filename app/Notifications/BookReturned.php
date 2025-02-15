<?php

namespace App\Notifications;

use App\Models\Book;
use App\Models\BookLoan;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class BookReturned extends Notification
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
            'message' => 'You have returned "' . $this->book->title . '"',
            'book_id' => $this->book->id,
            'loan_id' => $this->loan->id,
            'returned_date' => $this->loan->returned_date,
            'type' => 'book_returned',
            'url' => route('books.show', $this->book)
        ];
    }

    public function toArray($notifiable): array
    {
        return [
            'message' => 'You have returned "' . $this->book->title . '"',
            'book_id' => $this->book->id,
            'loan_id' => $this->loan->id,
            'returned_date' => $this->loan->returned_date,
            'type' => 'book_returned',
            'url' => route('books.show', $this->book)
        ];
    }
}
