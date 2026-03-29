<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Process\Process;

class ScrapeFacebookReviews extends Command
{
    protected $signature = 'facebook:scrape-reviews
        {url : The Facebook reviews page URL}
        {--limit=10 : Maximum number of reviews to return}
        {--save= : Optional storage/app path to save the JSON output}';

    protected $description = 'Scrape public Facebook page reviews with Playwright';

    public function handle(): int
    {
        $url = (string) $this->argument('url');
        $limit = max(1, (int) $this->option('limit'));
        $savePath = $this->option('save');

        $process = new Process([
            'node',
            base_path('scripts/scrape-facebook-reviews.mjs'),
            '--url', $url,
            '--limit', (string) $limit,
        ], base_path(), [
            'CI' => '1',
        ]);

        $process->setTimeout(180);
        $process->run();

        if (! $process->isSuccessful()) {
            $this->error(trim($process->getErrorOutput()) ?: 'The scraper failed.');

            return self::FAILURE;
        }

        $output = trim($process->getOutput());

        if ($output === '') {
            $this->error('The scraper returned no output.');

            return self::FAILURE;
        }

        $decoded = json_decode($output, true);

        if (! is_array($decoded)) {
            $this->error('The scraper returned invalid JSON.');

            return self::FAILURE;
        }

        if (is_string($savePath) && $savePath !== '') {
            Storage::put($savePath, json_encode($decoded, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
            $this->info(sprintf('Saved reviews to storage/app/%s', ltrim($savePath, '/')));
        }

        $this->line(json_encode($decoded, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

        return self::SUCCESS;
    }
}
