<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Schedule;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
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
        $appointments = Appointment::with('patients', 'doctors', 'services')->paginate(10);
        return view('Admin.Appointment.index')->with(['appointments' => $appointments]);
    }

    public function details(Request $request)
    {
        $appointment = Appointment::find($request->input('id'));
        //dd($appointments);
        return view('Admin.Appointment.details')->with(['appointment' => $appointment]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $schedules = Schedule::all();
        $patients = User::whereHas('roles', function ($q) {
            $q->where('name', 'patient');
        })->get();
        $doctors = User::whereHas('roles', function ($q) {
            $q->where('name', 'doctor');
        })->get();
        $services = Service::all();
        return view('Admin.Appointment.create')->with(['patients' => $patients, 'doctors' => $doctors, 'services' => $services,'schedules'=>$schedules]);
    }

    public function getDoctorId(Request $request){
    $doctorId = $request->post('doctor_id');
    if($doctorId==null){
        $schedules = Schedule::all();
    } else{
        $schedules = DB::table('schedules')->where('user_id',$doctorId)->get();
    }
    $html = '<option value="">Pick the appointment</option>';
    foreach ($schedules as $schedule){
        $html.='<option value="'.$schedule->id.'">'.$schedule->from.'-'.$schedule->to.'</option>';
    }
    echo $html;
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
        $schedule = Schedule::find($request->input('schedule_id'));
        $start_time = $schedule->from;
        $end_time = $schedule->to;

        $services = $request->input('services');
        $price_sum=0;
        foreach ($services as $service){
            $serviceObj = Service::find($service);
            $price_sum+=$serviceObj->price;
        }

        $appointment = new Appointment();
        $appointment->doctor_id = $doctor_id;
        $appointment->patient_id = $patient_id;
        $appointment->start_time = $start_time;
        $appointment->end_time = $end_time;
        $appointment->price = $price_sum;

        $appointment->save();
        $appointment->services()->sync($request->input('services'));
        Schedule::destroy($request->input('schedule_id'));
        return redirect(route('admin.appointment.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $appointment = Appointment::with('services','doctors','patients')->find($id);
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
