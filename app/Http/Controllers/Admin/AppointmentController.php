<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Schedule;
use App\Models\Service;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use phpDocumentor\Reflection\Types\ArrayKey;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $date = $request->input('datePicked');
        $parsedDate = Carbon::parse($date)->format('Y-m-d');

        $loggedUserId = Auth::user()->id;
        $loggedInUser = User::find($loggedUserId);
        if ($date == '') {
            if ($loggedInUser->hasAnyRole('admin')) {
                $appointments = Appointment::with('patients', 'doctors', 'services')->paginate(10);
            } else {
                $appointments = Appointment::with('patients', 'doctors', 'services')->where('doctor_id', $loggedUserId)->paginate(10);
            }
        } else {
            if ($loggedInUser->hasAnyRole('admin')) {
                $appointments = Appointment::with('patients', 'doctors', 'services')->whereDate('start_time', 'like', $parsedDate)->paginate(10);
            } else {
                $appointments = Appointment::with('patients', 'doctors', 'services')->whereDate('start_time', 'like', $parsedDate)->where('id', $loggedUserId)->paginate(10);
            }
        }

        return view('Admin.Appointment.index')->with(['appointments' => $appointments]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $schedules = DB::table('schedules')->where('from', '>=', Carbon::now()->utcOffset(120))->get();

        $patients = User::whereHas('roles', function ($q) {
            $q->where('name', 'patient');
        })->get();
        $doctors = User::whereHas('roles', function ($q) {
            $q->where('name', 'doctor');
        })->get();
        $services = Service::all();
        return view('Admin.Appointment.create')->with(['patients' => $patients, 'doctors' => $doctors, 'services' => $services, 'schedules' => $schedules]);
    }

    public function getDoctorId(Request $request)
    {
        $doctorId = $request->post('doctor_id');
        if ($doctorId == null) {
            $schedules = DB::table('schedules')->where('from', '>=', Carbon::now()->utcOffset(120))->where('user_id', $doctorId)->get();
        } else {
            $schedules = DB::select('SELECT DISTINCT DATE(s.from)AS day,s.user_id AS id FROM `schedules` AS s WHERE s.user_id=? AND s.from>=?', [$doctorId, Carbon::now()->utcOffset(120)]);
        }

        $date = '<option value="">Pick the date</option>';
        foreach ($schedules as $schedule) {
            $date .= '<option value="' . $schedule->id . '">' . $schedule->day . '</option>';
        }
        echo $date;
    }

    public function getDate(Request $request)
    {
        $date = $request->post('from');
        $doctorId = $request->post('doctor_id');
        $serviceIds = explode(',', $request->input('services'));
        $serviceTotalTime = 0;
        foreach ($serviceIds as $id) {
            $service = Service::find($id);
            $serviceTotalTime += $service->duration;
        }
        $numOfSchedules = $serviceTotalTime / 15;

        if ($date == null) {
            $schedules = DB::table('schedules')->where('from', '>', Carbon::now()->utcOffset(120))->where('user_id', $doctorId)->get();
        } else {
            $schedules = DB::table('schedules')->where('from', '>', Carbon::now()->utcOffset(120))->whereDate('from', $date)->where('user_id', $doctorId)->get();
        }

        $scheduleTimeDistincts = array();
        foreach ($schedules as $schedule) {
            $distinct = Carbon::parse($schedule->from)->format('H:i');
            if (!in_array($distinct, $scheduleTimeDistincts)) {
                $scheduleId = array('scheduleId' => $schedule->id);
                $distinctTime = array('time' => $distinct);
                $merged = array_merge($scheduleId, $distinctTime);
                $scheduleTimeDistincts[] = $merged;
            }
        }
        $time = '<option value="">Pick the time</option>';
        if ($numOfSchedules <= 1) {
            foreach ($scheduleTimeDistincts as $scheduleTimeDistinct) {
                $time .= '<option value="' . $scheduleTimeDistinct['scheduleId'] . '">' . $scheduleTimeDistinct['time'] . '</option>';
            }
        } elseif ($numOfSchedules > $schedules->count()) {
            $time = '<option value="">Pick the time</option>';
        } else {
            for ($i = 0; $i < $schedules->count(); $i++) {
                $counter = 1;
                for ($j = $i + 1; $j < $schedules->count(); $j++) {
                    $toTimeOfStartSchedule = Carbon::parse($schedules[$j - 1]->to)->format('H:i');
                    $fromTimeOfNextSchedule = Carbon::parse($schedules[$j]->from)->format('H:i');
                    if ($i < $schedules->count() - 1) {
                        if ($toTimeOfStartSchedule != $fromTimeOfNextSchedule) {
                            break;
                        }
                    }
                    $counter++;
                }
                if ($counter >= $numOfSchedules) {
                    $time .= '<option value="' . $scheduleTimeDistincts[$i]['scheduleId']. '">' . Carbon::parse($schedules[$i]->from)->format('H:i') . '</option>';
                }
            }
        }
        echo $time;
    }

    function array_push_assoc($array, $key, $value)
    {
        $array[$key] = $value;
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $doctor_id = $request->input('doctor_id');
        $patient_id = $request->input('patient_id');
        $scheduleId = $request->input('schedule');
        $services = $request->input('services');
        $schedule = Schedule::find($scheduleId);

        $start_time = $schedule->from;


        $price_sum = 0;
        $servicesDuration = 0;
        foreach ($services as $service) {
            $serviceObj = Service::find($service);
            $price_sum += $serviceObj->price;
            $servicesDuration += $serviceObj->duration;
        }
        $numOfSchedules = $servicesDuration / 15;
        $end_time = null;
        for ($i = 0; $i < $numOfSchedules; $i++) {
            $nextSchedule = Schedule::find($scheduleId + $i);
            $end_time = $nextSchedule->to;
        }

        $appointment = new Appointment();
        $appointment->doctor_id = $doctor_id;
        $appointment->patient_id = $patient_id;
        $appointment->start_time = $start_time;
        $appointment->end_time = $end_time;
        $appointment->price = $price_sum;

        $appointment->save();
        $appointment->services()->sync($request->input('services'));
        for ($i = 0; $i < $numOfSchedules; $i++) {
            $deleteSchedule = Schedule::find($scheduleId + $i);
            Schedule::destroy($deleteSchedule->id);
        }
        return redirect(route('admin.appointment.index'));


//        $doctor_id = $request->input('doctor_id');
//        $patient_id = $request->input('patient_id');
//        $scheduleId = $request->input('schedule');
//        $services = $request->input('services');
//        $schedule = Schedule::find($scheduleId);
//
//        $start_time = $schedule->from;
//
//
//        $price_sum = 0;
//        $servicesDuration = 0;
//        foreach ($services as $service) {
//            $serviceObj = Service::find($service);
//            $price_sum += $serviceObj->price;
//            $servicesDuration += $serviceObj->duration;
//        }
//        $numOfSchedules = $servicesDuration / 15;
//        $end_time = null;
//        for ($i = 0; $i < $numOfSchedules; $i++) {
//            $nextSchedule = Schedule::find($scheduleId+2);
//            $end_time = $nextSchedule->to;
//        }
//
//        $appointment = new Appointment();
//        $appointment->doctor_id = $doctor_id;
//        $appointment->patient_id = $patient_id;
//        $appointment->start_time = $start_time;
//        $appointment->end_time = $end_time;
//        $appointment->price = $price_sum;
//
//        $appointment->save();
//        $appointment->services()->sync($request->input('services'));
//
//        for ($i = 0; $i < $numOfSchedules; $i++) {
//            $deleteSchedule = Schedule::find($scheduleId + $i);
//            Schedule::destroy($deleteSchedule->id);
//        }
//        return redirect(route('admin.appointment.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $appointment = Appointment::with('services', 'doctors', 'patients')->find($id);
        return response()->json($appointment);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        dd($request);
        $appointment = Appointment::find($id);

        $appointment->update($request->except('_token'));

        return redirect(route('admin.appointment.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Appointment::destroy($id);
        return redirect(route('admin.appointment.index'));
    }
}
