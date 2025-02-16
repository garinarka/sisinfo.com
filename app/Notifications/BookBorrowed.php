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
    public $user;

    public function __construct(Book $book, BookLoan $loan)
    {
        $this->book = $book;
        $this->loan = $loan;
        $this->user = $loan->user;
    }

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toDatabase($notifiable): array
    {
        // Customize message based on recipient role
        if ($notifiable->hasRole('admin') || $notifiable->hasRole('operator')) {
            $message = "{$this->user->name} has borrowed \"{$this->book->title}\"";
        } else {
            $message = "You have borrowed \"{$this->book->title}\"";
        }

        return [
            'message' => $message,
            'book_id' => $this->book->id,
            'loan_id' => $this->loan->id,
            'user_id' => $this->user->id,
            'due_date' => $this->loan->due_date,
            'type' => 'book_borrowed',
            'url' => route('books.show', $this->book)
        ];
    }

    public function toArray($notifiable): array
    {
        // Customize message based on recipient role
        if ($notifiable->hasRole('admin') || $notifiable->hasRole('operator')) {
            $message = "{$this->user->name} has borrowed \"{$this->book->title}\"";
        } else {
            $message = "You have borrowed \"{$this->book->title}\"";
        }

        return [
            'message' => $message,
            'book_id' => $this->book->id,
            'loan_id' => $this->loan->id,
            'user_id' => $this->user->id,
            'due_date' => $this->loan->due_date,
            'type' => 'book_borrowed',
            'url' => route('books.show', $this->book)
        ];
    }
}
