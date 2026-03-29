<?php

namespace App\Livewire\Pages;

use App\Models\CustomerReview;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class LandingPage extends Component
{
    public array $galleryImages = [];

    public array $stats = [
        ['value' => '14+', 'label' => 'Years On The Tools'],
        ['value' => '1,500+', 'label' => 'Happy Customers'],
        ['value' => '6', 'label' => 'Core Services'],
        ['value' => '100%', 'label' => 'Built On Site'],
    ];

    public array $tickerItems = [
        'Fencing & Gates',
        'Wood Decking',
        'Pergolas',
        'Hot Tub Shelters',
        'UPVC Decking',
        'Caravan Verandas',
        'Sheds',
        'Landscaping',
        'Free Estimates',
    ];

    public array $services = [
        ['number' => '01', 'title' => 'Fencing & Gates', 'description' => 'Feather edge, close board, panel fencing and bespoke timber gates. Proper posts, proper footing depth, built for North Wales weather.', 'icon' => 'fence'],
        ['number' => '02', 'title' => 'Pergolas & Shelters', 'description' => 'Garden pergolas, lean-to shelters and hot tub enclosures built to fit your space rather than bought off the shelf.', 'icon' => 'pergola'],
        ['number' => '03', 'title' => 'Wood Decking', 'description' => 'Premium timber decking designed and installed to create usable outdoor living space with a strong, clean finish.', 'icon' => 'decking'],
        ['number' => '04', 'title' => 'UPVC Decking & Verandas', 'description' => 'Low-maintenance decking and caravan verandas that resist rot, fade and coastal wear all year round.', 'icon' => 'veranda'],
        ['number' => '05', 'title' => 'Sheds & Outbuildings', 'description' => 'Custom timber outbuildings built to your dimensions, whether you need storage, a workshop or a tidy garden feature.', 'icon' => 'shed'],
        ['number' => '06', 'title' => 'Landscaping & Groundworks', 'description' => 'Ground prep, levelling and landscape work that ties the whole project together and leaves the site finished properly.', 'icon' => 'landscape'],
    ];

    public array $processSteps = [
        ['step' => '1', 'title' => 'Get In Touch', 'description' => 'Call, message or use the form below with a rough idea of the job and where you are based.'],
        ['step' => '2', 'title' => 'Free Site Visit', 'description' => 'Lewis comes out, measures up, talks through the details and gives you a no-obligation quote.'],
        ['step' => '3', 'title' => 'Built On Site', 'description' => 'Everything is custom built on site using quality materials, with no flat-pack shortcuts.'],
        ['step' => '4', 'title' => 'Finished Properly', 'description' => 'You get a clean, durable result built to last and worth recommending to the next customer.'],
    ];

    public array $testimonials = [];

    public array $serviceOptions = [
        'Fencing & Gates',
        'Pergola / Hot Tub Shelter',
        'Wood Decking',
        'UPVC Decking / Caravan Veranda',
        'Shed / Outbuilding',
        'Landscaping / Groundworks',
        'Other / Not Sure',
    ];

    public array $coverageAreas = [
        'Abergele',
        'Prestatyn',
        'Colwyn Bay',
        'Rhyl',
        'Towyn',
        'Across North Wales',
    ];

    public function mount(): void
    {
        $this->galleryImages = collect(Storage::disk('public')->files('pics'))
            ->filter(fn (string $path): bool => str_ends_with(strtolower($path), '.jpg'))
            ->values()
            ->map(fn (string $path): string => Storage::url($path))
            ->all();

        $this->testimonials = CustomerReview::query()
            ->orderBy('id')
            ->get()
            ->map(fn (CustomerReview $review): array => [
                'quote' => $review->review_text,
                'author' => $review->reviewer_name,
                'location' => 'Facebook Review',
            ])
            ->all();

        if ($this->testimonials === []) {
            $this->testimonials = [
                ['quote' => 'Absolutely delighted with the new gate. Great communication, fair pricing and the finish is spot on. We would use LMC again without hesitation.', 'author' => 'Denise Roberts', 'location' => 'Abergele'],
                ['quote' => 'Lewis built us a brilliant decking area. He turned up when he said he would, quoted clearly and the final result lifted the whole garden.', 'author' => 'Mark & Julie T.', 'location' => 'Prestatyn'],
                ['quote' => 'A full run of fencing replaced after storm damage and it looks miles better than what was there before. Friendly, professional and solid work.', 'author' => 'Sarah M.', 'location' => 'Colwyn Bay'],
            ];
        }
    }

    public function render()
    {
        return view('livewire.pages.landing-page')
            ->layout('components.layouts.app', [
                'title' => 'LMC Fencing & Gates | Abergele, North Wales',
            ]);
    }
}
