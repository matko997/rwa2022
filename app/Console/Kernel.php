<?php

namespace App\Console;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            $doctors = User::whereHas('roles', function ($q) {
                $q->where('name', 'doctor');
            })->get()->pluck('id');

            foreach ($doctors as $doctor) {
                $now = Carbon::tomorrow();
                $start = Carbon::create($now->year, $now->month, $now->day, 8, 0, 0);
                for ($i = 0; $i < 32; $i++) {
                    DB::table('schedules')->insert([
                        'from' => $start->format('y-m-d H:i'),
                        'to' => $start->addMinutes('15')->format('y-m-d H:i'),
                        'user_id' => $doctor,
                        'created_at' => now()
                    ]);
                }
            }
        })->everyMinute();

    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
