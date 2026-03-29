<?php

namespace App\Console\Commands;

use App\Models\CustomerReview;
use Illuminate\Console\Command;

class ImportFacebookCaptureReviews extends Command
{
    protected $signature = 'reviews:import-facebook-capture';

    protected $description = 'Import customer reviews extracted from the saved Facebook capture';

    public function handle(): int
    {
        $rows = [
            [
                'reviewer_name' => 'Lee Hj',
                'review_text' => 'Highly recommend Lewis for any fencing and gate work. Really nice lads who arrive on time, work tidily and do a great job. They also listen to what the customer wants and then provide it. Really happy with the work and will be using again for further jobs I have planned! 10/10',
                'metadata' => [],
            ],
            [
                'reviewer_name' => 'Penny Williams',
                'review_text' => 'Fantastic outcome! Very professional & friendly. We absolutely love the pergola & how it\'s changed the garden and given us a nicer space to sit outside, ready for summer. Really done an amazing job. Thank you. Highly recommend.',
                'metadata' => [],
            ],
            [
                'reviewer_name' => 'Karen Woodham',
                'review_text' => 'LMC replaced our old ranch style garden fencing with a much stronger and better looking fence. They did a superb job, very professional, polite and extremely helpful. Highly recommended.',
                'metadata' => [],
            ],
            [
                'reviewer_name' => 'Steven Bowen',
                'review_text' => 'LMC recently replaced some fencing and posts. Top quality job done and will definitely use them in the future.',
                'metadata' => [],
            ],
            [
                'reviewer_name' => 'Leanne Roberts',
                'review_text' => 'LMC fencing provided a brilliant service. They were very quick to respond to my message and were able to fix my fence quickly and to a very high standard. Would definitely recommend them.',
                'metadata' => [],
            ],
            [
                'reviewer_name' => 'Hollie Ritchie',
                'review_text' => 'LMC installed a new fence and gate at our property and we couldn\'t be happier. Lewis arrived on time, worked quickly without compromising quality, and left everything spotless. Very professional throughout. Highly recommended for reliable, efficient fencing.',
                'metadata' => [],
            ],
            [
                'reviewer_name' => 'Louise Williams',
                'review_text' => 'Very reliable company who completed work on time and to an excellent standard. I am extremely happy with work completed and look forward to the second stage being started in the New Year. Lewis conducts himself in a professional manner and goes out of his way to assist.',
                'metadata' => [],
            ],
            [
                'reviewer_name' => 'Kathryn McCarroll',
                'review_text' => 'Just had work done by LMC fencing and gates, I would highly recommend them and definitely use them again.',
                'metadata' => [],
            ],
            [
                'reviewer_name' => 'Bettrev Kirwan',
                'review_text' => 'LMC Fencing have just completed a concrete retaining wall up our very steep garden. We couldn\'t have asked for more reliable and professional workers, they have done a fantastic job and we would highly recommend them. We would have no hesitation in using them again. Their work is to an extremely high standard and they are perfectionists ensuring that the customer is happy. We did not realise how difficult the job was going to be for t...',
                'metadata' => ['is_partial' => true],
            ],
            [
                'reviewer_name' => 'Aidan Conway',
                'review_text' => 'LMC have just completed building a new fence for us and we could not be happier. The whole experience has been amazing. Their communication is great, from a fast response to our initial enquiry, a quick follow up from coming out to measure up and delivering a quote, and also, providing a date to commence the work. Lewis and Owen are friendly, efficient and highly professional. They completed the job to the highest of standards and ...',
                'metadata' => ['is_partial' => true],
            ],
            [
                'reviewer_name' => 'Deborah Williams',
                'review_text' => 'Thanks for replacing a post to my fence this morning. Great job from start to finish. Highly recommend.',
                'metadata' => [],
            ],
            [
                'reviewer_name' => 'Keith Williams',
                'review_text' => 'fantastic work by Lewis & colleague. never stopped, from arrival just before 8am, until they completed the job, about 3pm. My garden fence was rotten and almost falling over, as well as the wooden door/gate. all fully replaced and looks good for the next 40 odd years. thanks.',
                'metadata' => [],
            ],
            [
                'reviewer_name' => 'Ian Archibald',
                'review_text' => 'Lewis is a quality tradesman. Extremely reliable and fully focused on delivering a quality service. Completes every project likes it\'s his own home. "Perfectionist"!!!!',
                'metadata' => [],
            ],
            [
                'reviewer_name' => 'Janet Davies',
                'review_text' => 'A professional job done by an amazing team from quote to finish. Would 100% recommend.',
                'metadata' => [],
            ],
            [
                'reviewer_name' => 'Suzanne Davies',
                'review_text' => 'Thanks for a great job in replacing a new post and securing our fence. Prompt and reliable and have asked them to come back to do other work.',
                'metadata' => [],
            ],
            [
                'reviewer_name' => 'Heather Moss',
                'review_text' => 'Thanks lads for today great service post and panel all replaced, clean tidy job, would definitely have again.',
                'metadata' => [],
            ],
            [
                'reviewer_name' => 'Natalie Bryan-Dewhurst',
                'review_text' => 'Lewis and his team recently come and repaired and replaced some storm damaged fencing! Good customer service & very reasonable quote for the work that was needed! Really happy with the work! Very quick turnaround! Would 100% recommend and will be having him back for more work in the future!',
                'metadata' => [],
            ],
            [
                'reviewer_name' => 'Denise Roberts',
                'review_text' => 'Absolutely delighted with the new gate installed today by LMC Fencing. Great customer service and Lewis really understood my needs. Very reasonably priced and the job was done quickly to a very high standard. Will definitely use LMC again.',
                'metadata' => [],
            ],
            [
                'reviewer_name' => 'Dan Williams',
                'review_text' => 'Highly recommend LMC, they came round quickly following our fences being destroyed by the recent storms and provided a competitive quote. Work has been carried out to a high standard and the fences look great.',
                'metadata' => [],
            ],
        ];

        foreach ($rows as $row) {
            CustomerReview::updateOrCreate(
                [
                    'reviewer_name' => $row['reviewer_name'],
                    'source' => 'facebook_screenshot',
                ],
                [
                    'review_text' => $row['review_text'],
                    'source_label' => 'LMC Fencing & Gates Facebook screenshot 2026-03-29',
                    'metadata' => array_merge([
                        'source_file' => 'C:/Users/dylan/Desktop/LMC Fencing & Gates _ Facebook.htm',
                        'source_image' => 'C:/Users/dylan/Desktop/Screenshot 2026-03-29 at 02-23-35 LMC Fencing & Gates Facebook.png',
                        'source_image_set' => 'chat screenshots 2026-03-29',
                    ], $row['metadata']),
                ]
            );
        }

        $this->info(sprintf('Imported %d reviews.', count($rows)));

        return self::SUCCESS;
    }
}
