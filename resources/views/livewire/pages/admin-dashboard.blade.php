@php
    $latestRequestAt = $stats['latest_request_at'] ? \Illuminate\Support\Carbon::parse($stats['latest_request_at']) : null;
@endphp

<div class="forge-noise min-h-screen py-10">
    <div class="section-shell space-y-8">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
            <div class="space-y-3">
                <p class="section-tag">Admin</p>
                <h1 class="font-display text-4xl font-bold uppercase tracking-[0.02em] text-white md:text-5xl">Site Dashboard</h1>
                <p class="max-w-2xl text-sm leading-7 text-ash">View recent quote requests, postcode coverage and the main lead numbers from the landing page.</p>
            </div>

            <div class="flex flex-wrap gap-3">
                <a href="{{ route('home') }}" class="clip-rust-sm border border-white/12 bg-white/6 px-5 py-3 font-condensed text-sm font-semibold uppercase tracking-[0.18em] text-white transition hover:border-white/25 hover:bg-white/10">
                    View Site
                </a>
                <a href="{{ route('admin.invoices') }}" class="clip-rust-sm border border-white/12 bg-white/6 px-5 py-3 font-condensed text-sm font-semibold uppercase tracking-[0.18em] text-white transition hover:border-white/25 hover:bg-white/10">
                    Invoices
                </a>
                <a href="{{ route('invoice.generate') }}" class="clip-rust-sm border border-rust/35 bg-rust/12 px-5 py-3 font-condensed text-sm font-semibold uppercase tracking-[0.18em] text-rust-light transition hover:bg-rust/20">
                    Generate
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="clip-rust-sm border border-white/12 bg-white/6 px-5 py-3 font-condensed text-sm font-semibold uppercase tracking-[0.18em] text-white transition hover:border-white/25 hover:bg-white/10">
                        Log Out
                    </button>
                </form>
            </div>
        </div>

        <div class="flex flex-wrap gap-3">
            <button type="button" wire:click="setTab('overview')" class="clip-rust-sm px-5 py-3 font-condensed text-sm font-semibold uppercase tracking-[0.18em] transition {{ $tab === 'overview' ? 'bg-rust text-white' : 'border border-white/12 bg-white/6 text-ash hover:border-white/25 hover:bg-white/10 hover:text-white' }}">
                Overview
            </button>
            <button type="button" wire:click="setTab('requests')" class="clip-rust-sm px-5 py-3 font-condensed text-sm font-semibold uppercase tracking-[0.18em] transition {{ $tab === 'requests' ? 'bg-rust text-white' : 'border border-white/12 bg-white/6 text-ash hover:border-white/25 hover:bg-white/10 hover:text-white' }}">
                Requests
            </button>
        </div>

        @if ($tab === 'overview')
            <div class="grid gap-[3px] md:grid-cols-2 xl:grid-cols-5">
                <article class="steel-card px-8 py-8">
                    <p class="font-condensed text-xs font-semibold uppercase tracking-[0.2em] text-ash">Total Requests</p>
                    <p class="mt-4 font-display text-5xl font-bold text-white">{{ number_format($stats['total_requests']) }}</p>
                </article>
                <article class="steel-card px-8 py-8">
                    <p class="font-condensed text-xs font-semibold uppercase tracking-[0.2em] text-ash">Site Visits</p>
                    <p class="mt-4 font-display text-5xl font-bold text-rust">{{ number_format($stats['site_visits']) }}</p>
                </article>
                <article class="steel-card px-8 py-8">
                    <p class="font-condensed text-xs font-semibold uppercase tracking-[0.2em] text-ash">New This Week</p>
                    <p class="mt-4 font-display text-5xl font-bold text-white">{{ number_format($stats['new_this_week']) }}</p>
                </article>
                <article class="steel-card px-8 py-8">
                    <p class="font-condensed text-xs font-semibold uppercase tracking-[0.2em] text-ash">New This Month</p>
                    <p class="mt-4 font-display text-5xl font-bold text-white">{{ number_format($stats['new_this_month']) }}</p>
                </article>
                <article class="steel-card px-8 py-8">
                    <p class="font-condensed text-xs font-semibold uppercase tracking-[0.2em] text-ash">Latest Request</p>
                    <p class="mt-4 text-lg font-semibold text-white">{{ $latestRequestAt?->format('d M Y, H:i') ?? 'No requests yet' }}</p>
                </article>
            </div>

            <div class="grid gap-8 xl:grid-cols-[1.1fr_.9fr]">
                <div class="steel-card p-6 lg:p-7">
                    <div class="flex items-center justify-between gap-4">
                        <h2 class="font-condensed text-lg font-semibold uppercase tracking-[0.18em] text-white">Recent Requests</h2>
                        <button type="button" wire:click="setTab('requests')" class="text-xs uppercase tracking-[0.18em] text-rust transition hover:text-rust-hot">Open requests tab</button>
                    </div>

                    <div class="mt-6 overflow-hidden border border-white/8">
                        <table class="w-full text-left text-sm">
                            <thead class="bg-white/5 text-ash">
                                <tr class="font-condensed uppercase tracking-[0.16em]">
                                    <th class="px-4 py-3">Name</th>
                                    <th class="px-4 py-3">Postcode</th>
                                    <th class="px-4 py-3">Service</th>
                                    <th class="px-4 py-3">Submitted</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($latestRequests as $request)
                                    <tr class="border-t border-white/8">
                                        <td class="px-4 py-3 text-white">{{ $request->name }}</td>
                                        <td class="px-4 py-3 text-silver">{{ $request->postcode }}</td>
                                        <td class="px-4 py-3 text-silver">{{ $request->service ?: 'Not specified' }}</td>
                                        <td class="px-4 py-3 text-silver">{{ optional($request->submitted_at)->format('d M Y H:i') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-4 py-6 text-center text-ash">No quote requests yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="space-y-8">
                    <div class="steel-card p-6 lg:p-7">
                        <h2 class="font-condensed text-lg font-semibold uppercase tracking-[0.18em] text-white">Service Breakdown</h2>
                        <div class="mt-6 space-y-4">
                            @forelse ($serviceBreakdown as $service)
                                <div class="flex items-center justify-between gap-4 border-b border-white/8 pb-4 last:border-0 last:pb-0">
                                    <div class="text-sm text-silver">{{ $service->service_name }}</div>
                                    <div class="font-display text-2xl font-bold text-rust">{{ $service->aggregate }}</div>
                                </div>
                            @empty
                                <p class="text-sm text-ash">No service data yet.</p>
                            @endforelse
                        </div>
                    </div>

                    <div class="steel-card p-6 lg:p-7">
                        <h2 class="font-condensed text-lg font-semibold uppercase tracking-[0.18em] text-white">Top Postcode Areas</h2>
                        <div class="mt-6 space-y-4">
                            @forelse ($postcodeBreakdown as $postcode => $count)
                                <div class="flex items-center justify-between gap-4 border-b border-white/8 pb-4 last:border-0 last:pb-0">
                                    <div class="text-sm text-silver">{{ $postcode }}</div>
                                    <div class="font-display text-2xl font-bold text-white">{{ $count }}</div>
                                </div>
                            @empty
                                <p class="text-sm text-ash">No postcode data yet.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="grid gap-8 xl:grid-cols-[1.1fr_.9fr]">
                <div class="steel-card overflow-hidden p-0">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-white/5 text-ash">
                            <tr class="font-condensed uppercase tracking-[0.16em]">
                                <th class="px-4 py-4">Name</th>
                                <th class="px-4 py-4">Postcode</th>
                                <th class="px-4 py-4">Service</th>
                                <th class="px-4 py-4">Submitted</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($requests as $request)
                                <tr wire:click="showRequest({{ $request->id }})" class="cursor-pointer border-t border-white/8 transition hover:bg-white/5 {{ optional($selectedRequest)->id === $request->id ? 'bg-white/5' : '' }}">
                                    <td class="px-4 py-4 text-white">
                                        <div class="font-medium">{{ $request->name }}</div>
                                        <div class="mt-1 text-xs text-ash">{{ $request->email }}</div>
                                    </td>
                                    <td class="px-4 py-4 text-silver">{{ $request->postcode }}</td>
                                    <td class="px-4 py-4 text-silver">{{ $request->service ?: 'Not specified' }}</td>
                                    <td class="px-4 py-4 text-silver">{{ optional($request->submitted_at)->format('d M Y H:i') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-4 py-6 text-center text-ash">No quote requests have been submitted yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="border-t border-white/8 px-4 py-4">
                        {{ $requests->links() }}
                    </div>
                </div>

                <div class="steel-card p-6 lg:p-7">
                    <h2 class="font-condensed text-lg font-semibold uppercase tracking-[0.18em] text-white">Request Details</h2>

                    @if ($selectedRequest)
                        <div class="mt-6 space-y-6 text-sm">
                            <div class="grid gap-4 sm:grid-cols-2">
                                <div>
                                    <div class="font-condensed text-xs uppercase tracking-[0.18em] text-ash">Name</div>
                                    <div class="mt-2 text-white">{{ $selectedRequest->name }}</div>
                                </div>
                                <div>
                                    <div class="font-condensed text-xs uppercase tracking-[0.18em] text-ash">Submitted</div>
                                    <div class="mt-2 text-white">{{ optional($selectedRequest->submitted_at)->format('d M Y H:i') }}</div>
                                </div>
                                <div>
                                    <div class="font-condensed text-xs uppercase tracking-[0.18em] text-ash">Phone</div>
                                    <div class="mt-2 text-white">{{ $selectedRequest->phone ?: '-' }}</div>
                                </div>
                                <div>
                                    <div class="font-condensed text-xs uppercase tracking-[0.18em] text-ash">Email</div>
                                    <div class="mt-2 break-all text-white">{{ $selectedRequest->email }}</div>
                                </div>
                                <div>
                                    <div class="font-condensed text-xs uppercase tracking-[0.18em] text-ash">Postcode</div>
                                    <div class="mt-2 text-white">{{ $selectedRequest->postcode }}</div>
                                </div>
                                <div>
                                    <div class="font-condensed text-xs uppercase tracking-[0.18em] text-ash">Service</div>
                                    <div class="mt-2 text-white">{{ $selectedRequest->service ?: 'Not specified' }}</div>
                                </div>
                            </div>

                            <div>
                                <div class="font-condensed text-xs uppercase tracking-[0.18em] text-ash">Message</div>
                                <div class="mt-2 whitespace-pre-line rounded-sm border border-white/8 bg-white/5 px-4 py-4 leading-7 text-silver">{{ $selectedRequest->message }}</div>
                            </div>
                        </div>
                    @else
                        <p class="mt-6 text-sm text-ash">Select a request to view the full details.</p>
                    @endif
                </div>
            </div>
        @endif
    </div>
</div>
