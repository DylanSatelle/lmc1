<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\AdminInvoiceSyncController;
use App\Http\Controllers\QuoteRequestController;
use App\Livewire\Pages\AdminDashboard;
use App\Livewire\Pages\AdminInvoices;
use App\Livewire\Pages\InvoiceGenerator;
use App\Livewire\Pages\LandingPage;
use Illuminate\Support\Facades\Route;

Route::get('/', LandingPage::class)->middleware('track.site.visit')->name('home');
Route::get('/generate', InvoiceGenerator::class)->name('invoice.generate');
Route::post('/quote-request', [QuoteRequestController::class, 'store'])->name('quote-request.store');

Route::middleware('guest')->group(function (): void {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login.store');
});

Route::middleware('auth')->group(function (): void {
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});

Route::middleware(['auth', 'admin'])->group(function (): void {
    Route::get('/admin', AdminDashboard::class)->name('admin.dashboard');
    Route::get('/admin/invoices', AdminInvoices::class)->name('admin.invoices');
    Route::post('/admin/invoices/sync', [AdminInvoiceSyncController::class, 'store'])->name('admin.invoices.sync');
});
