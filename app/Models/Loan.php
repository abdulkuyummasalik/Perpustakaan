<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Loan extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'book_id', 'borrowed_at', 'returned_at', 'deleted_by_user_at'];

    protected $casts = [
        'borrowed_at' => 'datetime',
        'returned_at' => 'datetime',
        'deleted_by_user_at' => 'datetime',
    ];

    public function scopeNotDeletedByUser($query)
    {
        return $query->whereNull('deleted_by_user_at');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
