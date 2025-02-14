<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class BorrowRecord extends Model
{
    use HasFactory;

    protected $fillable = ['borrowable_id', 'borrowable_type', 'user_id'];

    /**
     * Get the parent borrowable model (book, magazine, etc.).
     */
    public function borrowable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * A borrow record belongs to a user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
