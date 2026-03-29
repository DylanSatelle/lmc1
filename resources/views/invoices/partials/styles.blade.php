<style>
    *, *::before, *::after { box-sizing: border-box; }

    .invoice-sheet {
        background: #ffffff;
        color: #0e1114;
        width: 100%;
        max-width: 860px;
        margin: 0 auto;
        box-shadow: 0 20px 60px rgba(15, 20, 28, 0.24);
    }

    .invoice-header {
        background: #0e1114;
        padding: 40px 52px 36px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 32px;
    }

    .invoice-logo {
        display: flex;
        align-items: center;
        gap: 18px;
    }

    .invoice-logo-mark {
        width: 74px;
        height: 74px;
        display: block;
    }

    .invoice-brand-name,
    .invoice-title,
    .invoice-party-name,
    .invoice-grand-total {
        font-family: 'Oswald', sans-serif;
    }

    .invoice-brand-name {
        margin: 0 0 4px;
        color: #ffffff;
        font-size: 24px;
        line-height: 1;
        letter-spacing: 0.06em;
        text-transform: uppercase;
    }

    .invoice-brand-name span,
    .invoice-title,
    .invoice-amount,
    .invoice-grand-total {
        color: #01aaa7;
    }

    .invoice-brand-tagline,
    .invoice-number,
    .invoice-label,
    .invoice-table th,
    .invoice-status,
    .invoice-footer,
    .invoice-payment-label,
    .invoice-notes-label {
        font-family: 'Barlow Condensed', sans-serif;
        text-transform: uppercase;
        letter-spacing: 0.2em;
    }

    .invoice-brand-tagline,
    .invoice-number,
    .invoice-footer {
        color: rgba(255, 255, 255, 0.5);
    }

    .invoice-title-block {
        text-align: right;
    }

    .invoice-title {
        margin: 0 0 6px;
        font-size: 38px;
        line-height: 1;
        text-transform: uppercase;
    }

    .invoice-number {
        font-size: 13px;
    }

    .invoice-accent {
        height: 4px;
        background: #01aaa7;
    }

    .invoice-meta,
    .invoice-parties {
        display: grid;
    }

    .invoice-meta {
        grid-template-columns: repeat(3, 1fr);
        border-bottom: 1px solid #dde3e8;
    }

    .invoice-meta-cell,
    .invoice-party {
        padding: 28px 36px;
    }

    .invoice-meta-cell {
        border-right: 1px solid #dde3e8;
    }

    .invoice-meta-cell:last-child,
    .invoice-party:last-child {
        border-right: 0;
    }

    .invoice-label,
    .invoice-payment-label,
    .invoice-notes-label {
        margin: 0 0 6px;
        color: #007674;
        font-size: 11px;
    }

    .invoice-value {
        margin: 0;
        color: #0e1114;
        font-size: 15px;
        font-weight: 500;
    }

    .invoice-value-large {
        font-family: 'Oswald', sans-serif;
        font-size: 19px;
    }

    .invoice-value-due {
        color: #c0392b;
    }

    .invoice-parties {
        grid-template-columns: repeat(2, 1fr);
        border-bottom: 1px solid #dde3e8;
    }

    .invoice-party:first-child {
        border-right: 1px solid #dde3e8;
    }

    .invoice-party-name {
        margin: 0 0 6px;
        font-size: 20px;
    }

    .invoice-detail {
        margin: 0;
        color: #5a6472;
        font-size: 14px;
        line-height: 1.7;
    }

    .invoice-job {
        display: flex;
        gap: 16px;
        align-items: center;
        padding: 24px 36px;
        background: #e4f7f7;
        border-bottom: 1px solid #dde3e8;
    }

    .invoice-job-value {
        margin: 0;
        font-size: 15px;
        font-weight: 500;
    }

    .invoice-items {
        padding: 0 36px;
    }

    .invoice-table {
        width: 100%;
        border-collapse: collapse;
    }

    .invoice-table thead tr {
        border-bottom: 2px solid #0e1114;
    }

    .invoice-table th {
        padding: 20px 0 14px;
        font-size: 11px;
        text-align: left;
        color: #5a6472;
    }

    .invoice-table th:not(:first-child),
    .invoice-table td:not(:first-child) {
        text-align: right;
    }

    .invoice-table th.qty,
    .invoice-table td.qty {
        text-align: center;
    }

    .invoice-table tbody tr {
        border-bottom: 1px solid #dde3e8;
    }

    .invoice-table tbody tr:last-child {
        border-bottom: 0;
    }

    .invoice-table td {
        padding: 16px 0;
        vertical-align: top;
        font-size: 14px;
    }

    .invoice-item-name {
        margin: 0 0 3px;
        font-weight: 600;
    }

    .invoice-item-desc {
        margin: 0;
        color: #5a6472;
        font-size: 12px;
        line-height: 1.5;
    }

    .invoice-totals {
        display: flex;
        justify-content: flex-end;
        padding: 0 36px 36px;
        margin-top: 24px;
    }

    .invoice-totals-block {
        width: 300px;
    }

    .invoice-total-row {
        display: flex;
        justify-content: space-between;
        gap: 16px;
        padding: 10px 0;
        border-bottom: 1px solid #dde3e8;
        font-size: 14px;
    }

    .invoice-total-row:last-child {
        border-bottom: 0;
    }

    .invoice-total-label {
        color: #5a6472;
    }

    .invoice-total-value {
        font-weight: 600;
    }

    .invoice-total-row.invoice-total-grand {
        background: #0e1114;
        border-bottom: 0;
        margin-top: 8px;
        padding: 14px 18px;
    }

    .invoice-total-row.invoice-total-grand .invoice-total-label {
        color: rgba(255, 255, 255, 0.65);
    }

    .invoice-grand-total {
        font-size: 28px;
        line-height: 1;
    }

    .invoice-status {
        display: inline-block;
        margin-left: 8px;
        padding: 3px 10px;
        border-radius: 2px;
        font-size: 10px;
        font-weight: 700;
    }

    .invoice-status-awaiting-payment,
    .invoice-status-overdue {
        background: #fff3cd;
        color: #856404;
    }

    .invoice-status-paid {
        background: #d1f5d3;
        color: #155724;
    }

    .invoice-status-part-paid {
        background: #ffe4bf;
        color: #8a4b08;
    }

    .invoice-payment {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        margin: 0 36px 36px;
        padding: 24px 28px;
        background: #e4f7f7;
        border: 1px solid rgba(1, 170, 167, 0.25);
    }

    .invoice-payment-value {
        margin: 0;
        font-size: 14px;
        font-weight: 600;
    }

    .invoice-notes {
        margin: 0 36px 36px;
        padding: 20px 24px;
        border-left: 3px solid #01aaa7;
        background: #fafbfc;
    }

    .invoice-notes-text {
        margin: 0;
        color: #5a6472;
        font-size: 14px;
        line-height: 1.7;
    }

    .invoice-footer-band {
        background: #0e1114;
        padding: 22px 52px;
    }

    .invoice-footer {
        font-size: 12px;
        line-height: 1.7;
    }

    .invoice-footer strong {
        color: rgba(255, 255, 255, 0.8);
    }

    @media (max-width: 820px) {
        .invoice-header,
        .invoice-meta,
        .invoice-parties,
        .invoice-payment {
            display: block;
        }

        .invoice-header,
        .invoice-meta-cell,
        .invoice-party,
        .invoice-job,
        .invoice-items,
        .invoice-totals,
        .invoice-footer-band {
            padding-left: 24px;
            padding-right: 24px;
        }

        .invoice-title-block {
            text-align: left;
        }

        .invoice-meta-cell,
        .invoice-party {
            border-right: 0;
            border-bottom: 1px solid #dde3e8;
        }

        .invoice-payment {
            margin-left: 24px;
            margin-right: 24px;
        }
    }
</style>
