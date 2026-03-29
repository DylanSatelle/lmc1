<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceRecord extends Model
{
    protected $fillable = [
        'reference',
        'status',
        'invoice_date',
        'due_date',
        'job_address',
        'client_name',
        'total_due',
        'last_action',
        'public_pdf_path',
        'payload',
    ];

    protected function casts(): array
    {
        return [
            'invoice_date' => 'date',
            'due_date' => 'date',
            'total_due' => 'decimal:2',
            'payload' => 'array',
        ];
    }
}
