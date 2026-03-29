<?php

namespace App\Support;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class InvoiceRecordPersister
{
    public static function store(array $invoice, string $action, ?string $publicPdfPath = null): void
    {
        $now = now()->toDateTimeString();
        $pdo = DB::connection()->getPdo();
        $quote = static fn ($value) => $value === null ? 'NULL' : $pdo->quote((string) $value);
        $totalDue = number_format((float) ($invoice['totals']['total_due'] ?? 0), 2, '.', '');

        DB::unprepared(sprintf(
            'INSERT INTO invoice_records (
                reference, status, invoice_date, due_date, job_address, client_name, total_due, last_action, public_pdf_path, payload, created_at, updated_at
            ) VALUES (
                %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s
            )
            ON DUPLICATE KEY UPDATE
                status = VALUES(status),
                invoice_date = VALUES(invoice_date),
                due_date = VALUES(due_date),
                job_address = VALUES(job_address),
                client_name = VALUES(client_name),
                total_due = VALUES(total_due),
                last_action = VALUES(last_action),
                public_pdf_path = VALUES(public_pdf_path),
                payload = VALUES(payload),
                updated_at = VALUES(updated_at)',
            $quote($invoice['reference'] ?? ''),
            $quote($invoice['status'] ?? 'awaiting payment'),
            $quote($invoice['invoice_date'] ?? now()->toDateString()),
            $quote($invoice['due_date'] ?? now()->toDateString()),
            $quote(Str::limit((string) ($invoice['job_address'] ?? ''), 255, '')),
            $quote($invoice['client']['name'] ?? ''),
            $totalDue,
            $quote($action),
            $quote($publicPdfPath),
            $quote(json_encode($invoice, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)),
            $quote($now),
            $quote($now),
        ));
    }
}
