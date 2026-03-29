<?php

namespace App\Livewire\Pages;

use App\Models\QuoteRequest;
use App\Models\SiteVisit;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class AdminDashboard extends Component
{
    use WithPagination;

    #[Url(as: 'tab', keep: true)]
    public string $tab = 'overview';

    public ?int $selectedRequestId = null;

    public function setTab(string $tab): void
    {
        $this->tab = in_array($tab, ['overview', 'requests'], true) ? $tab : 'overview';
        $this->resetPage();
    }

    public function showRequest(int $requestId): void
    {
        $this->selectedRequestId = $requestId;
        $this->tab = 'requests';
    }

    public function render(): View
    {
        $requests = QuoteRequest::query()
            ->latest('submitted_at')
            ->latest()
            ->paginate(10);

        $latestRequests = QuoteRequest::query()
            ->latest('submitted_at')
            ->latest()
            ->limit(5)
            ->get();

        $serviceBreakdown = QuoteRequest::query()
            ->selectRaw('COALESCE(NULLIF(service, ""), "Not specified") as service_name, COUNT(*) as aggregate')
            ->groupBy('service_name')
            ->orderByDesc('aggregate')
            ->limit(6)
            ->get();

        $postcodeBreakdown = QuoteRequest::query()
            ->get(['postcode'])
            ->map(fn (QuoteRequest $request): string => Str::upper(Str::before(trim($request->postcode), ' ')))
            ->filter()
            ->countBy()
            ->sortDesc()
            ->take(6);

        $selectedRequest = $this->selectedRequestId
            ? QuoteRequest::query()->find($this->selectedRequestId)
            : $requests->first();

        $now = now();

        return view('livewire.pages.admin-dashboard', [
            'stats' => [
                'total_requests' => QuoteRequest::count(),
                'site_visits' => SiteVisit::count(),
                'new_this_week' => QuoteRequest::where('submitted_at', '>=', $now->copy()->subDays(7))->count(),
                'new_this_month' => QuoteRequest::whereBetween('submitted_at', [$now->copy()->startOfMonth(), $now->copy()->endOfMonth()])->count(),
                'latest_request_at' => QuoteRequest::max('submitted_at'),
            ],
            'latestRequests' => $latestRequests,
            'requests' => $requests,
            'selectedRequest' => $selectedRequest,
            'serviceBreakdown' => $serviceBreakdown,
            'postcodeBreakdown' => $postcodeBreakdown,
        ])->layout('components.layouts.app', [
            'title' => 'Admin | LMC Fencing & Gates',
        ]);
    }
}
