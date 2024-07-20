<?php

use App\Jobs\DeleteExpiredOfferJob;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Schedule::job(new DeleteExpiredOfferJob())->everyMinute();
// clean data
Schedule::command('otp:clean')->daily();
Schedule::command('telescope:prune')->daily();
Schedule::command('queue:prune-failed')->daily();