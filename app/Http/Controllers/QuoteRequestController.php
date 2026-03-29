<?php

namespace App\Http\Controllers;

use App\Models\QuoteRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class QuoteRequestController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'phone' => ['nullable', 'string', 'max:40'],
            'email' => ['required', 'email', 'max:255'],
            'postcode' => ['required', 'string', 'max:20'],
            'service' => ['nullable', 'string', 'max:100'],
            'message' => ['nullable', 'string', 'max:2000'],
        ]);

        QuoteRequest::create([
            ...$validated,
            'postcode' => Str::upper(trim($validated['postcode'])),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'submitted_at' => now(),
        ]);

        return redirect(route('home') . '#contact')
            ->with('quote_success', 'Thanks. Your quote request has been received and will be reviewed shortly.');
    }
}
