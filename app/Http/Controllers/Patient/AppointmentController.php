<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Schedule;
use App\Models\Service;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function setTime(Request $request)
    {
        $date = $request->post('from');
        $referer = request()->headers->get('referer');
        $exploded = explode('/', $referer, 5);
        $doctorId = $exploded[4];


        $serviceIds = explode(',', $request->input('services'));
        $serviceTotalTime = 0;
        foreach ($serviceIds as $id) {
            $service = Service::find($id);
            $serviceTotalTime += $service->duration;
        }
        $numOfSchedules = $serviceTotalTime / 15;

        if ($date == null) {
            $schedules = Schedule::all();
        } else {
            $schedules = DB::table('schedules')->whereDate('from', $date)->where('user_id', $doctorId)->get();
        }

        $time = '<option value="">Pick the time</option>';
        if ($numOfSchedules <= 1) {
            foreach ($schedules as $schedule) {
                $time .= '<option value="' . $schedule->id . '">' . Carbon::parse($schedule->from)->format('H:i') . '</option>';
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
                    $time .= '<option value="' . $schedules[$i]->id . '">' . Carbon::parse($schedules[$i]->from)->format('H:i') . '</option>';
                }
            }
        }
        echo $time;
    }

    public function makeAppointment($doctorId)
    {
        $services = Service::all();

        $schedules = DB::table('schedules')->where('from', '>=', Carbon::now()->utcOffset(120))->where('user_id', $doctorId)->get();
        $scheduleDateDistinct = array();
        foreach ($schedules as $schedule) {
            $distinct = Carbon::parse($schedule->from)->format('Y-m-d');
            if (!in_array($distinct, $scheduleDateDistinct)) {
                $scheduleDateDistinct[] = $distinct;
            }
        }
        return view('makeAppointment')->with([
            'services' => $services,
            'schedules' => $schedules,
            'schedulesDayDistinct' => $scheduleDateDistinct,
            'doctorId' => $doctorId
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $doctor_id = $request->input('doctorId');
        $patient_id = Auth::user()->id;
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
            $nextSchedule = Schedule::find($scheduleId+$i);
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
        return redirect(route('patient.appointments'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getServices()
    {
        $services = Service::paginate(10);
        return view('patient.price-list')->with(['services' => $services]);
    }

    public function getPatientInfo()
    {
        $patient = Auth::user();
        return view('patient.patient-info')->with(['patient' => $patient]);
    }

    public function getPatientAppointments()
    {
        $appointments = Appointment::with('doctors')->where('patient_id', Auth::user()->id)->paginate(10);
        return view('patient.patient-appointments')->with(['appointments' => $appointments]);
    }

    public function updatePatientProfile(Request $request)
    {
        $name = $request->input('name');
        $surname = $request->input('surname');
        $email = $request->input('email');
        $phoneNumber = $request->input('phoneNumber');

        $user = Auth::user();

        $user->name = $name;
        $user->surname = $surname;
        $user->email = $email;
        $user->phoneNumber = $phoneNumber;

        $user->save();

        return redirect(route('patient.info'));

    }

    public function cancelAppointment($id)
    {
        $appointment=Appointment::find($id);

        $appointment->canceled=1;
        $appointment->save();

        return redirect(route('patient.appointments'));

    }
}
