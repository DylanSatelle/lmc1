# LMC Fencing & Gates

Marketing site and admin tooling for LMC Fencing & Gates, built with Laravel 13, Livewire 3, Tailwind 4, and Vite.

This project includes:
- a public landing page
- quote request capture
- an admin dashboard
- invoice generation and invoice tracking
- imported Facebook customer reviews
- offline-capable invoice draft storage for iPhone use

## Stack

- PHP 8.3
- Laravel 13
- Livewire 3
- MySQL
- Vite
- Tailwind CSS 4
- `barryvdh/laravel-dompdf` for PDF invoices
- Playwright for Facebook review scraping

## Main Routes

- `/` public landing page
- `/generate` invoice generator
- `/login` admin login
- `/admin` admin dashboard
- `/admin/invoices` saved invoices table

## Features

### Public Site

- custom landing page for LMC Fencing & Gates
- rotating customer review cards driven from database records
- quote request form stored in the database
- site visit tracking for the homepage

### Admin

- overview dashboard for quote requests and site visits
- requests tab with request details
- invoices page with:
  - reference
  - status
  - invoice and due dates
  - job
  - billed to
  - total owed
- quick invoice status updates from the table

### Invoice Generator

- live invoice preview
- PDF download
- send by email
- WhatsApp share flow
- invoice persistence into `invoice_records`

### Offline Invoice Drafts

The invoice page has a first-pass offline workflow for iPhone:

- caches the invoice page shell with a service worker
- stores invoice form drafts locally on the device
- allows drafts to be queued while offline
- syncs queued drafts back to Laravel once online

Current limitation:
- offline draft entry and later sync work
- server-side PDF generation still requires internet

## Setup

### 1. Install dependencies

```bash
composer install
npm install
```

### 2. Environment

```bash
cp .env.example .env
php artisan key:generate
```

Set your database credentials in `.env`.

### 3. Run migrations

```bash
php artisan migrate
```

### 4. Build frontend assets

```bash
npm run build
```

### 5. Start locally

Quick start:

```bash
php artisan serve
```

For the full local dev stack:

```bash
composer run dev
```

## Useful Commands

### Create an Admin User

```bash
php artisan admin:create-user "Your Name" "you@example.com" "secure-password"
```

### Import Saved Facebook Reviews

```bash
php artisan reviews:import-facebook-capture
```

### Scrape Facebook Reviews

```bash
php artisan facebook:scrape-reviews "https://www.facebook.com/lmclandscaping1/reviews" --limit=10 --save=facebook/lmclandscaping1-reviews.json
```

## Database Tables

Main project tables:

- `users`
- `quote_requests`
- `customer_reviews`
- `site_visits`
- `invoice_records`

## Invoice Record Flow

Invoice records are created or updated when the generator is used for:

- PDF download
- email send
- WhatsApp share
- offline sync from a cached device draft

Saved invoice metadata includes:

- `reference`
- `status`
- `invoice_date`
- `due_date`
- `job_address`
- `client_name`
- `total_due`
- `last_action`
- full invoice `payload`

## Offline iPhone Notes

To use the invoice page offline on iPhone:

1. Open `/generate` once while online.
2. Let the page finish loading.
3. Optionally add it to the Home Screen.
4. If offline, fill out the invoice and use `Save Offline`.
5. Reopen the page when online and use `Sync Drafts` if it does not sync automatically.

## Deployment Notes

Minimum deployment steps after pulling new code:

```bash
composer install --no-dev --optimize-autoloader
php artisan migrate --force
npm install
npm run build
php artisan view:clear
php artisan view:cache
```

If config or routes are cached in your environment, also run:

```bash
php artisan config:cache
php artisan route:cache
```

## Git

This repo is configured to use GitHub over SSH.

Example remote:

```bash
git remote add origin git@github.com:DylanSatelle/lmc1.git
```

Standard workflow:

```bash
git add .
git commit -m "Your message"
git push
```

## Project Notes

- Facebook scraping is best-effort only and may break if Facebook changes its markup or access rules.
- Some imported reviews were shortened to fit the landing-page testimonial cards cleanly.
- The invoice system currently uses Laravel server-side PDF rendering, not client-side PDF generation.
