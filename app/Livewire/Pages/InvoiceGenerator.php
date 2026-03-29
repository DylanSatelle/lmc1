<?php

namespace App\Livewire\Pages;

use App\Mail\InvoiceGeneratedMail;
use App\Support\InvoiceRecordPersister;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Component;

class InvoiceGenerator extends Component
{
    public string $reference = 'LMC-2026-0042';
    public string $status = 'awaiting payment';
    public string $invoiceDate = '';
    public string $dueDate = '';
    public string $jobAddress = 'Supply & installation of feather edge fencing and timber gate - 14 Bryn Mawr Close, Prestatyn, LL19 8BT';

    public string $senderCompany = 'LMC Fencing & Gates';
    public string $senderTagline = 'Fencing & Decking Specialists';
    public string $senderAddress = "Abergele, North Wales";
    public string $senderPhone = '07961 417 550';
    public string $senderEmail = 'LewisMClayton1@icloud.com';
    public string $senderWebsite = 'lmcfencingandgates.co.uk';

    public string $clientName = 'Mr & Mrs D. Evans';
    public string $clientAddress = "14 Bryn Mawr Close\nPrestatyn\nDenbighshire, LL19 8BT";
    public string $clientPhone = '07700 900 123';
    public string $clientEmail = 'customer@example.com';

    public string $vatRate = '0';
    public string $discount = '0';

    public string $paymentMethod = 'Bank Transfer (BACS)';
    public string $paymentSortCode = '30-00-00';
    public string $paymentAccountNumber = '12345678';
    public string $paymentAccountName = 'L M Clayton';
    public string $paymentReference = 'LMC-2026-0042';

    public string $notes = 'Thank you for choosing LMC Fencing & Gates. Payment is due within 14 days of invoice date. Please use the invoice reference when making your transfer. All work is guaranteed for 12 months from installation date. We are not VAT registered unless otherwise stated.';

    public string $emailTo = 'customer@example.com';
    public string $emailSubject = '';
    public string $emailMessage = 'Please find your invoice attached. If you have any questions about the job or payment details, reply to this email or call Lewis directly.';
    public string $whatsAppNumber = '07700900123';
    public string $whatsAppMessage = 'Hi, your invoice from LMC Fencing & Gates is ready. You can view and download it here:';

    public array $items = [];

    public function mount(): void
    {
        $this->invoiceDate = now()->format('Y-m-d');
        $this->dueDate = now()->addDays(14)->format('Y-m-d');
        $this->emailSubject = sprintf('Invoice %s from %s', $this->reference, $this->senderCompany);

        $this->items = [
            [
                'name' => '6ft Feather Edge Fencing - Supply & Install',
                'description' => '4x4 treated timber posts set 900mm in ground. Gravel boards. Feather edge boards to 6ft. Includes concrete post mix.',
                'quantity' => '8',
                'unit' => 'bays',
                'unit_price' => '185',
            ],
            [
                'name' => 'Bespoke Timber Side Gate - Supply & Install',
                'description' => 'T&G timber side gate, 900mm wide x 1.8m high. Galvanised hinges and bolt latch. Pressure treated finish.',
                'quantity' => '1',
                'unit' => 'item',
                'unit_price' => '320',
            ],
            [
                'name' => 'Removal & Disposal of Existing Fencing',
                'description' => 'Strip out and removal of 8 bays of old panel fencing and broken posts. Skip hire included.',
                'quantity' => '1',
                'unit' => 'job',
                'unit_price' => '160',
            ],
        ];
    }

    public function addItem(): void
    {
        $this->items[] = [
            'name' => '',
            'description' => '',
            'quantity' => '1',
            'unit' => 'item',
            'unit_price' => '0',
        ];
    }

    public function removeItem(int $index): void
    {
        if (count($this->items) === 1) {
            return;
        }

        unset($this->items[$index]);
        $this->items = array_values($this->items);
    }

    public function downloadPdf()
    {
        $invoice = $this->validatedInvoiceData();
        $this->storeInvoiceRecord($invoice, 'downloaded');
        $pdfBinary = $this->pdfBinary($invoice);
        $filename = $this->invoiceFilename($invoice);

        return response()->streamDownload(function () use ($pdfBinary): void {
            echo $pdfBinary;
        }, $filename, [
            'Content-Type' => 'application/pdf',
        ]);
    }

    public function sendInvoiceEmail(): void
    {
        $invoice = $this->validatedInvoiceData();
        $this->storeInvoiceRecord($invoice, 'emailed');
        $pdfBinary = $this->pdfBinary($invoice);
        $filename = $this->invoiceFilename($invoice);

        Mail::to($this->emailTo)->send(
            new InvoiceGeneratedMail(
                invoice: $invoice,
                pdfBinary: $pdfBinary,
                filename: $filename,
                body: $this->emailMessage,
            )
        );

        session()->flash('invoice_success', sprintf(
            'Invoice emailed to %s using the current mailer (%s).',
            $this->emailTo,
            config('mail.default')
        ));
    }

    public function shareOnWhatsApp(): void
    {
        $invoice = $this->validatedInvoiceData();
        $pdfBinary = $this->pdfBinary($invoice);
        $filename = $this->invoiceFilename($invoice);
        $path = 'invoices/' . Str::uuid() . '-' . $filename;

        Storage::disk('public')->put($path, $pdfBinary);
        $this->storeInvoiceRecord($invoice, 'whatsapp', $path);

        $invoiceUrl = url(Storage::url($path));
        $message = trim($this->whatsAppMessage . ' ' . $invoiceUrl);
        $number = preg_replace('/\D+/', '', $this->whatsAppNumber);

        $url = $number !== ''
            ? sprintf('https://wa.me/%s?text=%s', $number, urlencode($message))
            : sprintf('https://api.whatsapp.com/send?text=%s', urlencode($message));

        $this->dispatch('open-url', url: $url);

        session()->flash('invoice_success', 'WhatsApp share link opened with a generated PDF link.');
    }

    public function render()
    {
        return view('livewire.pages.invoice-generator', [
            'invoice' => $this->invoicePreviewData(),
        ])->layout('components.layouts.app', [
            'title' => 'Generate Invoice | LMC Fencing & Gates',
        ]);
    }

    protected function rules(): array
    {
        return [
            'reference' => ['required', 'string', 'max:60'],
            'status' => ['required', 'string', 'max:40'],
            'invoiceDate' => ['required', 'date'],
            'dueDate' => ['required', 'date', 'after_or_equal:invoiceDate'],
            'jobAddress' => ['required', 'string', 'max:255'],
            'senderCompany' => ['required', 'string', 'max:120'],
            'senderTagline' => ['nullable', 'string', 'max:120'],
            'senderAddress' => ['required', 'string', 'max:255'],
            'senderPhone' => ['required', 'string', 'max:40'],
            'senderEmail' => ['required', 'email', 'max:255'],
            'senderWebsite' => ['nullable', 'string', 'max:120'],
            'clientName' => ['required', 'string', 'max:120'],
            'clientAddress' => ['required', 'string', 'max:255'],
            'clientPhone' => ['nullable', 'string', 'max:40'],
            'clientEmail' => ['nullable', 'email', 'max:255'],
            'vatRate' => ['required', 'numeric', 'min:0', 'max:100'],
            'discount' => ['required', 'numeric', 'min:0'],
            'paymentMethod' => ['required', 'string', 'max:120'],
            'paymentSortCode' => ['nullable', 'string', 'max:40'],
            'paymentAccountNumber' => ['nullable', 'string', 'max:40'],
            'paymentAccountName' => ['nullable', 'string', 'max:120'],
            'paymentReference' => ['required', 'string', 'max:60'],
            'notes' => ['nullable', 'string', 'max:2000'],
            'emailTo' => ['required', 'email', 'max:255'],
            'emailSubject' => ['required', 'string', 'max:255'],
            'emailMessage' => ['nullable', 'string', 'max:2000'],
            'whatsAppNumber' => ['nullable', 'string', 'max:40'],
            'whatsAppMessage' => ['required', 'string', 'max:500'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.name' => ['required', 'string', 'max:120'],
            'items.*.description' => ['nullable', 'string', 'max:500'],
            'items.*.quantity' => ['required', 'numeric', 'min:0.01'],
            'items.*.unit' => ['nullable', 'string', 'max:30'],
            'items.*.unit_price' => ['required', 'numeric', 'min:0'],
        ];
    }

    protected function validatedInvoiceData(): array
    {
        $this->validate();

        return $this->invoicePreviewData();
    }

    protected function invoicePreviewData(): array
    {
        $items = collect($this->items)
            ->map(function (array $item): array {
                $quantity = (float) $item['quantity'];
                $unitPrice = (float) $item['unit_price'];

                return [
                    'name' => $item['name'],
                    'description' => $item['description'],
                    'quantity' => $quantity,
                    'unit' => $item['unit'],
                    'unit_price' => $unitPrice,
                    'line_total' => round($quantity * $unitPrice, 2),
                ];
            })
            ->values()
            ->all();

        $subtotal = round(collect($items)->sum('line_total'), 2);
        $discount = round((float) $this->discount, 2);
        $vatAmount = round(max($subtotal - $discount, 0) * ((float) $this->vatRate / 100), 2);
        $totalDue = round(max($subtotal - $discount, 0) + $vatAmount, 2);

        return [
            'reference' => $this->reference,
            'status' => $this->status,
            'invoice_date' => $this->invoiceDate,
            'due_date' => $this->dueDate,
            'job_address' => $this->jobAddress,
            'sender' => [
                'company' => $this->senderCompany,
                'tagline' => $this->senderTagline,
                'address' => $this->senderAddress,
                'phone' => $this->senderPhone,
                'email' => $this->senderEmail,
                'website' => $this->senderWebsite,
            ],
            'client' => [
                'name' => $this->clientName,
                'address' => $this->clientAddress,
                'phone' => $this->clientPhone,
                'email' => $this->clientEmail,
            ],
            'items' => $items,
            'totals' => [
                'subtotal' => $subtotal,
                'discount' => $discount,
                'vat_rate' => round((float) $this->vatRate, 2),
                'vat_amount' => $vatAmount,
                'total_due' => $totalDue,
            ],
            'payment' => [
                'method' => $this->paymentMethod,
                'sort_code' => $this->paymentSortCode,
                'account_number' => $this->paymentAccountNumber,
                'account_name' => $this->paymentAccountName,
                'reference' => $this->paymentReference,
            ],
            'notes' => $this->notes,
            'email' => [
                'to' => $this->emailTo,
                'subject' => $this->emailSubject,
                'body' => $this->emailMessage,
            ],
            'whatsapp' => [
                'number' => $this->whatsAppNumber,
                'message' => $this->whatsAppMessage,
            ],
        ];
    }

    protected function pdfBinary(array $invoice): string
    {
        return Pdf::loadView('invoices.pdf', [
            'invoice' => $invoice,
            'logo' => $this->logoDataUri(),
            'watermark' => $this->watermarkDataUri(),
            'pdfMode' => true,
        ])->setPaper('a4')->output();
    }

    protected function invoiceFilename(array $invoice): string
    {
        $reference = Str::slug($invoice['reference']);

        return ($reference !== '' ? $reference : 'invoice') . '.pdf';
    }

    protected function storeInvoiceRecord(array $invoice, string $action, ?string $publicPdfPath = null): void
    {
        InvoiceRecordPersister::store($invoice, $action, $publicPdfPath);
    }

    protected function logoDataUri(): string
    {
        $path = storage_path('app/public/lmc.svg');
        $contents = file_get_contents($path);

        return 'data:image/svg+xml;base64,' . base64_encode($contents ?: '');
    }

    protected function watermarkDataUri(): string
    {
        $path = storage_path('app/public/lmcorig.svg');
        $contents = file_get_contents($path);

        return 'data:image/svg+xml;base64,' . base64_encode($contents ?: '');
    }
}
