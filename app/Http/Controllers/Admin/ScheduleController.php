<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use App\Models\User;
use App\Rules\DifferenceBetweenFromAndTo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ScheduleController extends Controller
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
                $schedules = Schedule::with('users')->paginate(10);
            } else {
                $schedules = Schedule::with('users')->where('user_id', $loggedUserId)->paginate(10);
            }
        } else {
            if ($loggedInUser->hasAnyRole('admin')) {
                $schedules = Schedule::with('users')->whereDate('from', $parsedDate)->paginate(10);
            } else {
                $schedules = Schedule::with('users')->whereDate('from', $parsedDate)->where('user_id', $loggedUserId)->paginate(10);
            }
        }

        return view('Admin.Schedule.index')->with(['schedules' => $schedules]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $doctors = User::whereHas('roles', function ($q) {
            $q->where('name', 'doctor');
        })->get();

        return view('Admin.Schedule.create')->with(['doctors' => $doctors]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $from = Carbon::create($request->input('from'));
        $to = Carbon::create($request->input('to'));

        $diff = $from->diffInMinutes($to);
        $fromMin = $from->format('i');
        $toMin = $to->format('i');


        if ($diff != 15 || $fromMin % 15 != 0 || $toMin % 15 != 0 || Carbon::now()->greaterThan($from)) {
            return redirect()->route('admin.schedule.create')
                ->with('error', 'Invalid date format!');
        }

        Schedule::create($request->except('_token'));
        return redirect(route('admin.schedule.index'))->with("Success", "Schedule created successfully");

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
        Schedule::destroy($id);
        return redirect(route('admin.schedule.index'));
    }


}
