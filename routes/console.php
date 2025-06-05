<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

//Artisan::command('inspire', function () {
  //  $this->comment(Inspiring::quote());
//})->purpose('Display an inspiring quote')->hourly();

use Illuminate\Console\Scheduling\Schedule;

//Schedule::command('inspire')->hourly(); // Example default command

return function (Schedule $schedule) {
    $schedule->exec('cd product-recommendation && uvicorn main:app --host 127.0.0.1 --port 9000 --reload')
             ->withoutOverlapping();
};
