<?php

namespace App\Http\Controllers;

use App\Support\InvoiceRecordPersister;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AdminInvoiceSyncController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'invoices' => ['required', 'array', 'min:1'],
            'invoices.*.reference' => ['required', 'string', 'max:60'],
            'invoices.*.status' => ['required', 'string', 'max:40'],
            'invoices.*.invoice_date' => ['required', 'date'],
            'invoices.*.due_date' => ['required', 'date'],
            'invoices.*.job_address' => ['required', 'string', 'max:255'],
            'invoices.*.client.name' => ['required', 'string', 'max:120'],
            'invoices.*.totals.total_due' => ['required', 'numeric', 'min:0'],
        ]);

        foreach ($validated['invoices'] as $invoice) {
            InvoiceRecordPersister::store($invoice, 'offline sync');
        }

        return response()->json([
            'synced' => count($validated['invoices']),
        ]);
    }
}
