<?php

namespace App\Livewire\Pages;

use App\Models\InvoiceRecord;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class AdminInvoices extends Component
{
    use WithPagination;

    public function updateStatus(int $invoiceId, string $status): void
    {
        $allowedStatuses = ['awaiting payment', 'part paid', 'paid', 'overdue'];

        if (! in_array($status, $allowedStatuses, true)) {
            return;
        }

        InvoiceRecord::query()
            ->whereKey($invoiceId)
            ->update(['status' => $status]);
    }

    public function render(): View
    {
        return view('livewire.pages.admin-invoices', [
            'invoices' => InvoiceRecord::query()
                ->latest('invoice_date')
                ->latest()
                ->paginate(15),
        ])->layout('components.layouts.app', [
            'title' => 'Invoices | LMC Fencing & Gates',
        ]);
    }
}
