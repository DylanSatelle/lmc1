<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerReview extends Model
{
    use HasFactory;

    protected $fillable = [
        'reviewer_name',
        'review_text',
        'source',
        'source_label',
        'reviewed_at',
        'imported_at',
        'metadata',
    ];

    protected function casts(): array
    {
        return [
            'reviewed_at' => 'datetime',
            'imported_at' => 'datetime',
            'metadata' => 'array',
        ];
    }
}
