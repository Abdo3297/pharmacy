<?php

namespace App\Jobs;

use App\Models\Offer;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DeleteExpiredOfferJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $offers = Offer::all();
        foreach ($offers as $offer) {
            $endDate = Carbon::parse($offer->end_date);
            if (Carbon::now()->greaterThanOrEqualTo($endDate)) {
                $offer->delete();
            }
        }
    }
}
