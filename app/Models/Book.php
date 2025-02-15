<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'author',
        'isbn',
        'description',
        'quantity',
        'is_available',
    ];

    protected $casts = [
        'is_available' => 'boolean',
    ];

    public function bookLoans(): HasMany
    {
        return $this->hasMany(BookLoan::class);
    }
}
