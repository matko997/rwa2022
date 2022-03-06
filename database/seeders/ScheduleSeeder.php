<?php

namespace Database\Seeders;

use App\Models\Schedule;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class ScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */


    public function run()
    {
        $doctors=User::whereHas('roles', function($q)
        {
            $q->where('name', 'doctor');
        })->get()->pluck('id');


        $start=Carbon::create(2022,3,6,8,0,0);
        $end=Carbon::create(2022,3,6,15,45,0);
        $intervals = CarbonInterval::minutes(15)->toPeriod($start, $end);

        foreach ($intervals as $date)
        {
            DB::table('schedules')->insert([
                'from'=>$date->format('y-m-d H:i'),
                'to'=>$date->addMinutes('15')->format('y-m-d H:i'),
                'user_id'=>$doctors->random(),
            ]);
        }

    }
}
