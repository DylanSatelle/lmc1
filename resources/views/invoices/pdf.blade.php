@php
    $statusSlug = \Illuminate\Support\Str::slug($invoice['status']);
    $clientAddress = collect(preg_split('/\r\n|\r|\n/', $invoice['client']['address'] ?? '') ?: [])->filter();
    $money = fn (float $amount): string => 'GBP ' . number_format($amount, 2);
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Invoice {{ $invoice['reference'] }}</title>
    <style>
        @page { margin: 10px; }
        body {
            margin: 0;
            background: #f4f6f8;
            color: #0e1114;
            font-family: DejaVu Sans, sans-serif;
            font-size: 10px;
            line-height: 1.28;
        }
        .sheet {
            position: relative;
            width: 100%;
            background: #ffffff;
            border: 1px solid #dde3e8;
            overflow: hidden;
        }
        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            width: 370px;
            height: 370px;
            margin-left: -185px;
            margin-top: -185px;
            opacity: 0.08;
            z-index: 0;
        }
        .sheet-inner {
            position: relative;
            z-index: 1;
        }
        .header {
            width: 100%;
            background: #0e1114;
            color: #ffffff;
        }
        .header td {
            padding: 16px 18px 14px;
            vertical-align: middle;
        }
        .brand-table {
            width: 100%;
            border-collapse: collapse;
        }
        .brand-table td {
            padding: 0;
            border: 0;
            vertical-align: middle;
        }
        .logo {
            width: 46px;
            height: 46px;
            margin-right: 8px;
        }
        .brand-name {
            font-size: 15px;
            font-weight: 700;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            color: #ffffff;
            margin: 0 0 3px;
        }
        .brand-name span,
        .title,
        .grand-value {
            color: #01aaa7;
        }
        .muted-light,
        .number,
        .footer {
            color: #b2bac3;
        }
        .tagline,
        .number,
        .label,
        .items th,
        .status,
        .payment-label,
        .notes-label,
        .footer {
            font-size: 8px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.18em;
        }
        .title-wrap {
            text-align: right;
        }
        .title {
            margin: 0 0 3px;
            font-size: 20px;
            line-height: 1;
            text-transform: uppercase;
            font-weight: 700;
        }
        .accent {
            height: 3px;
            background: #01aaa7;
        }
        .meta {
            width: 100%;
            border-collapse: collapse;
        }
        .meta td {
            width: 33.333%;
            padding: 10px 12px;
            border-right: 1px solid #dde3e8;
            border-bottom: 1px solid #dde3e8;
            vertical-align: top;
        }
        .meta td:last-child {
            border-right: 0;
        }
        .label,
        .payment-label,
        .notes-label {
            color: #007674;
            margin: 0 0 6px;
        }
        .value {
            margin: 0;
            font-size: 12px;
            font-weight: 700;
            color: #0e1114;
        }
        .value.due {
            color: #c0392b;
        }
        .parties {
            width: 100%;
            border-collapse: collapse;
        }
        .parties td {
            width: 50%;
            padding: 12px;
            border-right: 1px solid #dde3e8;
            border-bottom: 1px solid #dde3e8;
            vertical-align: top;
        }
        .parties td:last-child {
            border-right: 0;
        }
        .party-name {
            margin: 0 0 6px;
            font-size: 12px;
            font-weight: 700;
        }
        .detail {
            color: #5a6472;
            margin: 0;
            font-size: 10px;
            line-height: 1.3;
        }
        .job {
            padding: 9px 12px;
            background: #e4f7f7;
            border-bottom: 1px solid #dde3e8;
        }
        .job-value {
            margin: 0;
            font-size: 11px;
            font-weight: 700;
        }
        .items-wrap {
            padding: 0 12px;
        }
        .items {
            width: 100%;
            border-collapse: collapse;
        }
        .items thead tr {
            border-bottom: 2px solid #0e1114;
        }
        .items th {
            padding: 8px 0 6px;
            text-align: left;
            color: #5a6472;
        }
        .items th:nth-child(2),
        .items td:nth-child(2) {
            text-align: center;
        }
        .items th:nth-child(n+3),
        .items td:nth-child(n+3) {
            text-align: right;
        }
        .items td {
            padding: 7px 0;
            border-bottom: 1px solid #dde3e8;
            vertical-align: top;
        }
        .item-name {
            margin: 0 0 3px;
            font-weight: 700;
        }
        .item-desc {
            margin: 0;
            color: #5a6472;
            font-size: 9px;
            line-height: 1.28;
        }
        .totals-wrap {
            padding: 8px 12px 12px;
        }
        .totals {
            width: 36%;
            margin-left: auto;
            border-collapse: collapse;
        }
        .totals td {
            padding: 4px 0;
            border-bottom: 1px solid #dde3e8;
        }
        .totals td:last-child {
            text-align: right;
            font-weight: 700;
        }
        .total-label {
            color: #5a6472;
        }
        .grand-row td {
            background: #0e1114;
            border-bottom: 0;
            padding: 8px 10px;
        }
        .grand-row .total-label {
            color: #b2bac3;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.18em;
        }
        .grand-value {
            font-size: 18px;
            font-weight: 700;
        }
        .status {
            display: inline-block;
            margin-left: 8px;
            padding: 2px 7px;
            border-radius: 2px;
        }
        .status.awaiting-payment,
        .status.overdue {
            background: #fff3cd;
            color: #856404;
        }
        .status.paid {
            background: #d1f5d3;
            color: #155724;
        }
        .status.part-paid {
            background: #ffe4bf;
            color: #8a4b08;
        }
        .payment {
            width: calc(100% - 24px);
            margin: 0 12px 12px;
            border-collapse: collapse;
            background: #e4f7f7;
            border: 1px solid #b7e8e7;
        }
        .payment td {
            width: 33.333%;
            padding: 8px 10px;
            vertical-align: top;
        }
        .payment-value {
            margin: 0;
            font-size: 11px;
            font-weight: 700;
        }
        .payment-value.due {
            color: #c0392b;
        }
        .notes {
            margin: 0 12px 12px;
            padding: 9px 11px;
            border-left: 3px solid #01aaa7;
            background: #fafbfc;
        }
        .notes-text {
            margin: 0;
            color: #5a6472;
            font-size: 10px;
            line-height: 1.3;
        }
        .footer-band {
            background: #0e1114;
            padding: 9px 12px;
        }
        .footer {
            margin: 0;
            line-height: 1.3;
        }
        .footer strong {
            color: #ffffff;
        }
    </style>
</head>
<body>
    <div class="sheet">
        <img class="watermark" src="{{ $watermark }}" alt="">

        <div class="sheet-inner">
        <table class="header" cellspacing="0" cellpadding="0">
            <tr>
                <td style="width: 62%;">
                    <table class="brand-table">
                        <tr>
                            <td style="width: 76px;">
                                <img class="logo" src="{{ $logo }}" alt="LMC logo">
                            </td>
                            <td>
                                <p class="brand-name">LMC <span>&amp;</span> Gates</p>
                                <p class="tagline muted-light">{{ $invoice['sender']['tagline'] }}</p>
                            </td>
                        </tr>
                    </table>
                </td>
                <td class="title-wrap" style="width: 38%;">
                    <p class="title">Invoice</p>
                    <p class="number">
                        #{{ $invoice['reference'] }}
                        <span class="status {{ $statusSlug }}">{{ $invoice['status'] }}</span>
                    </p>
                </td>
            </tr>
        </table>

        <div class="accent"></div>

        <table class="meta" cellspacing="0" cellpadding="0">
            <tr>
                <td>
                    <p class="label">Invoice Date</p>
                    <p class="value">{{ \Illuminate\Support\Carbon::parse($invoice['invoice_date'])->format('d F Y') }}</p>
                </td>
                <td>
                    <p class="label">Due Date</p>
                    <p class="value due">{{ \Illuminate\Support\Carbon::parse($invoice['due_date'])->format('d F Y') }}</p>
                </td>
                <td>
                    <p class="label">Reference</p>
                    <p class="value">#{{ $invoice['reference'] }}</p>
                </td>
            </tr>
        </table>

        <table class="parties" cellspacing="0" cellpadding="0">
            <tr>
                <td>
                    <p class="label">From</p>
                    <p class="party-name">{{ $invoice['sender']['company'] }}</p>
                    <p class="detail">
                        {{ $invoice['sender']['address'] }}<br>
                        {{ $invoice['sender']['phone'] }}<br>
                        {{ $invoice['sender']['email'] }}<br>
                        {{ $invoice['sender']['website'] }}
                    </p>
                </td>
                <td>
                    <p class="label">Bill To</p>
                    <p class="party-name">{{ $invoice['client']['name'] }}</p>
                    <p class="detail">
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
                </td>
            </tr>
        </table>

        <div class="job">
            <p class="label">Job / Site Address</p>
            <p class="job-value">{{ $invoice['job_address'] }}</p>
        </div>

        <div class="items-wrap">
            <table class="items" cellspacing="0" cellpadding="0">
                <thead>
                    <tr>
                        <th style="width: 46%;">Description</th>
                        <th style="width: 10%;">Qty</th>
                        <th style="width: 16%;">Unit Price</th>
                        <th style="width: 12%;">VAT</th>
                        <th style="width: 16%;">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($invoice['items'] as $item)
                        <tr>
                            <td>
                                <p class="item-name">{{ $item['name'] }}</p>
                                @if (! empty($item['description']))
                                    <p class="item-desc">{{ $item['description'] }}</p>
                                @endif
                            </td>
                            <td>{{ rtrim(rtrim(number_format($item['quantity'], 2, '.', ''), '0'), '.') }} {{ $item['unit'] }}</td>
                            <td>{{ $money($item['unit_price']) }}</td>
                            <td>{{ $invoice['totals']['vat_rate'] > 0 ? number_format($invoice['totals']['vat_rate'], 2) . '%' : 'N/A' }}</td>
                            <td><strong>{{ $money($item['line_total']) }}</strong></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="totals-wrap">
            <table class="totals" cellspacing="0" cellpadding="0">
                <tr>
                    <td class="total-label">Subtotal</td>
                    <td>{{ $money($invoice['totals']['subtotal']) }}</td>
                </tr>
                <tr>
                    <td class="total-label">VAT ({{ number_format($invoice['totals']['vat_rate'], 2) }}%)</td>
                    <td>{{ $money($invoice['totals']['vat_amount']) }}</td>
                </tr>
                <tr>
                    <td class="total-label">Discount</td>
                    <td>- {{ $money($invoice['totals']['discount']) }}</td>
                </tr>
                <tr class="grand-row">
                    <td class="total-label">Total Due</td>
                    <td class="grand-value">{{ $money($invoice['totals']['total_due']) }}</td>
                </tr>
            </table>
        </div>

        <table class="payment" cellspacing="0" cellpadding="0">
            <tr>
                <td>
                    <p class="payment-label">Payment Method</p>
                    <p class="payment-value">{{ $invoice['payment']['method'] }}</p>
                </td>
                <td>
                    <p class="payment-label">Sort Code</p>
                    <p class="payment-value">{{ $invoice['payment']['sort_code'] ?: '-' }}</p>
                </td>
                <td>
                    <p class="payment-label">Account Number</p>
                    <p class="payment-value">{{ $invoice['payment']['account_number'] ?: '-' }}</p>
                </td>
            </tr>
            <tr>
                <td>
                    <p class="payment-label">Account Name</p>
                    <p class="payment-value">{{ $invoice['payment']['account_name'] ?: '-' }}</p>
                </td>
                <td>
                    <p class="payment-label">Reference</p>
                    <p class="payment-value">{{ $invoice['payment']['reference'] }}</p>
                </td>
                <td>
                    <p class="payment-label">Payment Due</p>
                    <p class="payment-value due">{{ \Illuminate\Support\Carbon::parse($invoice['due_date'])->format('d F Y') }}</p>
                </td>
            </tr>
        </table>

        <div class="notes">
            <p class="notes-label">Notes &amp; Terms</p>
            <p class="notes-text">{{ $invoice['notes'] }}</p>
        </div>

        <div class="footer-band">
            <p class="footer">
                <strong>{{ $invoice['sender']['phone'] }}</strong> | <strong>{{ $invoice['sender']['email'] }}</strong> | <strong>{{ $invoice['sender']['website'] }}</strong> | <strong>{{ $invoice['sender']['address'] }}</strong><br>
                Sole Trader | Not VAT Registered unless stated otherwise
            </p>
        </div>
        </div>
    </div>
</body>
</html>
