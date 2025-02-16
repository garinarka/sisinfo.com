<?php

namespace App\Models;

use App\Notifications\BookBorrowed;
use App\Notifications\BookReturned;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BookLoan extends Model
{
    protected $fillable = [
        'user_id',
        'book_id',
        'borrowed_date',
        'due_date',
        'returned_date',
        'status',
    ];

    protected $casts = [
        'borrowed_date' => 'datetime',
        'due_date' => 'datetime',
        'returned_date' => 'datetime',
    ];

    protected static function booted()
    {
        static::created(function ($loan) {
            // Notify the borrower
            $loan->user->notify(new BookBorrowed($loan->book, $loan));

            // Get admin and operator users through role relationship
            $adminsAndOperators = User::whereHas('role', function ($query) {
                $query->whereIn('name', ['admin', 'operator']);
            })
            ->where('id', '!=', $loan->user_id)
            ->get();

            // Notify admins and operators
            foreach ($adminsAndOperators as $admin) {
                $admin->notify(new BookBorrowed($loan->book, $loan));
            }
        });

        static::updated(function ($loan) {
            if ($loan->isDirty('returned_date') && $loan->returned_date !== null) {
                // Notify the borrower
                $loan->user->notify(new BookReturned($loan->book, $loan));

                // Notify admins and operators
                $adminsAndOperators = User::whereHas('role', function ($query) {
                    $query->whereIn('name', ['admin', 'operator']);
                })
                ->where('id', '!=', $loan->user_id)
                ->get();

                foreach ($adminsAndOperators as $admin) {
                    $admin->notify(new BookReturned($loan->book, $loan));
                }
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }
}
