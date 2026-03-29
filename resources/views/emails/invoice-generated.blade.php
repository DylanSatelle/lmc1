<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>{{ $invoice['email']['subject'] }}</title>
</head>
<body style="margin: 0; background: #f4f6f8; padding: 32px 20px; font-family: Arial, sans-serif; color: #0e1114;">
    <div style="max-width: 640px; margin: 0 auto; background: #ffffff; border: 1px solid #dde3e8; padding: 32px;">
        <p style="margin: 0 0 16px; font-size: 15px;">{{ $body }}</p>
        <p style="margin: 0 0 12px; font-size: 15px;"><strong>Invoice:</strong> {{ $invoice['reference'] }}</p>
        <p style="margin: 0 0 12px; font-size: 15px;"><strong>Total due:</strong> £{{ number_format($invoice['totals']['total_due'], 2) }}</p>
        <p style="margin: 0 0 12px; font-size: 15px;"><strong>Due date:</strong> {{ \Illuminate\Support\Carbon::parse($invoice['due_date'])->format('d F Y') }}</p>
        <p style="margin: 0; font-size: 14px; color: #5a6472;">A PDF copy of the invoice is attached to this email.</p>
    </div>
</body>
</html>
