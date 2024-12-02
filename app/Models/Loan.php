<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\LoanController;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Loan extends Model
{
    use HasFactory;

    // protected $fillable = ['user_id', 'book_id', 'borrowed_at', 'returned_at', 'deleted_by_user_at'];

    protected $guarded = [];

    protected $casts = [
        'borrowed_at' => 'datetime',
        'returned_at' => 'datetime',
        'due_date' => 'datetime',
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

    public function calculateFine()
    {
        // Jika buku sudah dikembalikan, gunakan denda akhir
        if ($this->returned_at) {
            return $this->final_fine ?? 0;
        }

        $now = now();
        $dueDate = $this->due_date;

        // Hitung denda berdasarkan hari
        if ($now->greaterThan($dueDate)) {
            $daysLate = $now->diffInDays($dueDate);
            return $daysLate * LoanController::FINE_PER_DAY; // denda per hari
        }

        return 0;
    }
}
