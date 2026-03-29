@php
    $statusSlug = \Illuminate\Support\Str::slug($invoice['status']);
    $formatMoney = fn (float $amount): string => '£' . number_format($amount, 2);
    $clientAddress = collect(preg_split('/\r\n|\r|\n/', $invoice['client']['address'] ?? '') ?: [])->filter();
@endphp

<div class="invoice-sheet">
    <div class="invoice-header">
        <div class="invoice-logo">
            <img class="invoice-logo-mark" src="{{ $logo }}" alt="LMC Fencing & Gates logo">
            <div>
                <p class="invoice-brand-name">LMC <span>&amp;</span> Gates</p>
                <p class="invoice-brand-tagline">{{ $invoice['sender']['tagline'] }}</p>
            </div>
        </div>

        <div class="invoice-title-block">
            <p class="invoice-title">Invoice</p>
            <p class="invoice-number">
                #{{ $invoice['reference'] }}
                <span class="invoice-status invoice-status-{{ $statusSlug }}">{{ $invoice['status'] }}</span>
            </p>
        </div>
    </div>

    <div class="invoice-accent"></div>

    <div class="invoice-meta">
        <div class="invoice-meta-cell">
            <p class="invoice-label">Invoice Date</p>
            <p class="invoice-value invoice-value-large">{{ \Illuminate\Support\Carbon::parse($invoice['invoice_date'])->format('d F Y') }}</p>
        </div>
        <div class="invoice-meta-cell">
            <p class="invoice-label">Due Date</p>
            <p class="invoice-value invoice-value-large invoice-value-due">{{ \Illuminate\Support\Carbon::parse($invoice['due_date'])->format('d F Y') }}</p>
        </div>
        <div class="invoice-meta-cell">
            <p class="invoice-label">Reference</p>
            <p class="invoice-value invoice-value-large">#{{ $invoice['reference'] }}</p>
        </div>
    </div>

    <div class="invoice-parties">
        <div class="invoice-party">
            <p class="invoice-label">From</p>
            <p class="invoice-party-name">{{ $invoice['sender']['company'] }}</p>
            <p class="invoice-detail">
                {{ $invoice['sender']['address'] }}<br>
                {{ $invoice['sender']['phone'] }}<br>
                {{ $invoice['sender']['email'] }}<br>
                {{ $invoice['sender']['website'] }}
            </p>
        </div>

        <div class="invoice-party">
            <p class="invoice-label">Bill To</p>
            <p class="invoice-party-name">{{ $invoice['client']['name'] }}</p>
            <p class="invoice-detail">
                @foreach ($clientAddress as $line)
                    {{ $line }}<br>
                @endforeach
                @if (! empty($invoice['client']['phone']))
                    {{ $invoice['client']['phone'] }}<br>
                @endif
                @if (! empty($invoice['client']['email']))
                    {{ $invoice['client']['email'] }}
                @endif
            </p>
        </div>
    </div>

    <div class="invoice-job">
        <p class="invoice-label">Job / Site Address</p>
        <p class="invoice-job-value">{{ $invoice['job_address'] }}</p>
    </div>

    <div class="invoice-items">
        <table class="invoice-table">
            <thead>
                <tr>
                    <th style="width: 46%;">Description</th>
                    <th class="qty" style="width: 10%;">Qty</th>
                    <th style="width: 16%;">Unit Price</th>
                    <th style="width: 12%;">VAT</th>
                    <th style="width: 16%;">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($invoice['items'] as $item)
                    <tr>
                        <td>
                            <p class="invoice-item-name">{{ $item['name'] }}</p>
                            @if (! empty($item['description']))
                                <p class="invoice-item-desc">{{ $item['description'] }}</p>
                            @endif
                        </td>
                        <td class="qty">{{ rtrim(rtrim(number_format($item['quantity'], 2, '.', ''), '0'), '.') }} {{ $item['unit'] }}</td>
                        <td>{{ $formatMoney($item['unit_price']) }}</td>
                        <td>{{ $invoice['totals']['vat_rate'] > 0 ? $invoice['totals']['vat_rate'] . '%' : 'N/A' }}</td>
                        <td><strong>{{ $formatMoney($item['line_total']) }}</strong></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="invoice-totals">
        <div class="invoice-totals-block">
            <div class="invoice-total-row">
                <span class="invoice-total-label">Subtotal</span>
                <span class="invoice-total-value">{{ $formatMoney($invoice['totals']['subtotal']) }}</span>
            </div>
            <div class="invoice-total-row">
                <span class="invoice-total-label">VAT ({{ number_format($invoice['totals']['vat_rate'], 2) }}%)</span>
                <span class="invoice-total-value">{{ $formatMoney($invoice['totals']['vat_amount']) }}</span>
            </div>
            <div class="invoice-total-row">
                <span class="invoice-total-label">Discount</span>
                <span class="invoice-total-value">- {{ $formatMoney($invoice['totals']['discount']) }}</span>
            </div>
            <div class="invoice-total-row invoice-total-grand">
                <span class="invoice-total-label">Total Due</span>
                <span class="invoice-grand-total">{{ $formatMoney($invoice['totals']['total_due']) }}</span>
            </div>
        </div>
    </div>

    <div class="invoice-payment">
        <div>
            <p class="invoice-payment-label">Payment Method</p>
            <p class="invoice-payment-value">{{ $invoice['payment']['method'] }}</p>
        </div>
        <div>
            <p class="invoice-payment-label">Sort Code</p>
            <p class="invoice-payment-value">{{ $invoice['payment']['sort_code'] ?: '-' }}</p>
        </div>
        <div>
            <p class="invoice-payment-label">Account Number</p>
            <p class="invoice-payment-value">{{ $invoice['payment']['account_number'] ?: '-' }}</p>
        </div>
        <div>
            <p class="invoice-payment-label">Account Name</p>
            <p class="invoice-payment-value">{{ $invoice['payment']['account_name'] ?: '-' }}</p>
        </div>
        <div>
            <p class="invoice-payment-label">Reference</p>
            <p class="invoice-payment-value">{{ $invoice['payment']['reference'] }}</p>
        </div>
        <div>
            <p class="invoice-payment-label">Payment Due</p>
            <p class="invoice-payment-value invoice-value-due">{{ \Illuminate\Support\Carbon::parse($invoice['due_date'])->format('d F Y') }}</p>
        </div>
    </div>

    <div class="invoice-notes">
        <p class="invoice-notes-label">Notes &amp; Terms</p>
        <p class="invoice-notes-text">{{ $invoice['notes'] }}</p>
    </div>

    <div class="invoice-footer-band">
        <p class="invoice-footer">
            <strong>{{ $invoice['sender']['phone'] }}</strong> | <strong>{{ $invoice['sender']['email'] }}</strong> | <strong>{{ $invoice['sender']['website'] }}</strong> | <strong>{{ $invoice['sender']['address'] }}</strong><br>
            Sole Trader | Not VAT Registered unless stated otherwise
        </p>
    </div>
</div>
