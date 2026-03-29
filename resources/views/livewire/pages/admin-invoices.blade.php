<div class="forge-noise min-h-screen py-10">
    <div class="section-shell space-y-8">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
            <div class="space-y-3">
                <p class="section-tag">Admin</p>
                <h1 class="font-display text-4xl font-bold uppercase tracking-[0.02em] text-white md:text-5xl">Invoices Created</h1>
                <p class="max-w-2xl text-sm leading-7 text-ash">Track references, due dates, billed clients and balances in one place.</p>
            </div>

            <div class="flex flex-wrap gap-3">
                <a href="{{ route('admin.dashboard') }}" class="clip-rust-sm border border-white/12 bg-white/6 px-5 py-3 font-condensed text-sm font-semibold uppercase tracking-[0.18em] text-white transition hover:border-white/25 hover:bg-white/10">
                    Dashboard
                </a>
                <a href="{{ route('invoice.generate') }}" class="clip-rust-sm border border-rust/35 bg-rust/12 px-5 py-3 font-condensed text-sm font-semibold uppercase tracking-[0.18em] text-rust-light transition hover:bg-rust/20">
                    Generate
                </a>
            </div>
        </div>

        <div class="steel-card overflow-hidden p-0">
            <table class="w-full text-left text-sm">
                <thead class="bg-white/5 text-ash">
                    <tr class="font-condensed uppercase tracking-[0.16em]">
                        <th class="px-4 py-4">Ref</th>
                        <th class="px-4 py-4">Status</th>
                        <th class="px-4 py-4">Dates</th>
                        <th class="px-4 py-4">Job</th>
                        <th class="px-4 py-4">Billed To</th>
                        <th class="px-4 py-4 text-right">Total Owed</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($invoices as $invoice)
                        <tr class="border-t border-white/8 align-top">
                            <td class="px-4 py-4 text-white">
                                <div class="font-semibold">{{ $invoice->reference }}</div>
                                <div class="mt-1 text-xs uppercase tracking-[0.14em] text-ash">{{ $invoice->last_action }}</div>
                            </td>
                            <td class="px-4 py-4">
                                <select wire:change="updateStatus({{ $invoice->id }}, $event.target.value)" class="w-full min-w-[11rem] border border-white/10 bg-white/5 px-3 py-2 text-xs font-semibold uppercase tracking-[0.14em] text-white outline-none transition focus:border-rust">
                                    @foreach (['awaiting payment' => 'Awaiting Payment', 'part paid' => 'Part Paid', 'paid' => 'Paid', 'overdue' => 'Overdue'] as $value => $label)
                                        <option value="{{ $value }}" @selected($invoice->status === $value)>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="px-4 py-4 text-silver">
                                <div>Invoice: {{ optional($invoice->invoice_date)->format('d M Y') ?? '-' }}</div>
                                <div class="mt-1 text-xs text-ash">Due: {{ optional($invoice->due_date)->format('d M Y') ?? '-' }}</div>
                            </td>
                            <td class="max-w-sm px-4 py-4 text-silver">{{ $invoice->job_address }}</td>
                            <td class="px-4 py-4 text-white">{{ $invoice->client_name }}</td>
                            <td class="px-4 py-4 text-right font-display text-2xl font-bold text-rust">£{{ number_format((float) $invoice->total_due, 2) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-ash">No invoices created yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="border-t border-white/8 px-4 py-4">
                {{ $invoices->links() }}
            </div>
        </div>
    </div>
</div>
