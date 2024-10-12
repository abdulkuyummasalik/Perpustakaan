<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'author',
        'publisher',
        'year',
        'stock',
        'category_id',
        'slug',
        'image',
    ];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function loans()
{
    return $this->hasMany(Loan::class); // Relasi one-to-many ke model Loan
}

}
