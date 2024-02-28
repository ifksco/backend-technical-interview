<?php

namespace App\Jobs;

use App\Models\User;
use App\Services\SeoUrlsApiClient;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ActualizeUserArticleSeoSlugs implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
    }

    /**
     * Execute the job.
     */
    public function handle(User $user): void
    {
        $apiClient = new SeoUrlsApiClient();

        $apiClient->actualizeSeoSlugs($user);
    }
}
