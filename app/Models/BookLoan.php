<?php

namespace App\Models;

use App\Notifications\BookBorrowed;
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
            $loan->user->notify(new BookBorrowed($loan->book, $loan));
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
