<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['name', 'isbn', 'authors', 'country', 'number_of_pages', 'publisher', 'release_date'];

    protected $casts = [
        'authors' => 'array',
    ];

    public function getBookNameAttribute()
    {
        return $this->name;
    }
}
