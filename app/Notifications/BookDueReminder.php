<?php

namespace App\Notifications;

use App\Models\Book;
use App\Models\BookLoan;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BookDueReminder extends Notification implements ShouldQueue
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
            ->subject('Book Due Soon - ' . $this->book->title)
            ->line('The book you borrowed is due soon:')
            ->line('Book: ' . $this->book->title)
            ->line('Due date: ' . $this->loan->due_date->format('Y-m-d'))
            ->action('View Book Details', route('books.show', $this->book))
            ->line('Please return the book before the due date to avoid any penalties.');
    }

    public function toArray($notifiable): array
    {
        return [
            'message' => 'Book "' . $this->book->title . '" is due on ' . $this->loan->due_date->format('Y-m-d'),
            'book_id' => $this->book->id,
            'loan_id' => $this->loan->id,
            'due_date' => $this->loan->due_date,
            'type' => 'book_due'
        ];
    }
}
