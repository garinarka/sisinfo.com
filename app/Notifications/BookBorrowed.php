<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BookBorrowed extends Notification
{
    use Queueable;

    protected $bookLoan;

    /**
     * Create a new notification instance.
     */
    public function __construct($bookLoan)
    {
        $this->bookLoan = $bookLoan;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('A book has been borrowed')
            ->line('Book: ' . $this->bookLoan->book->title)
            ->line('Borrowed by: ' . $this->bookLoan->user->name)
            ->line('Due date: ' . $this->bookLoan->due_date->format('d-m-Y'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'book_loan_id' => $this->bookLoan->id,
            'book_title' => $this->bookLoan->book->title,
            'borrower_name' => $this->bookLoan->user->name,
            'due_date' => $this->bookLoan->due_date,
        ];
    }
}
