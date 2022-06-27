<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;


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
        if($date==''){
            $schedules=Schedule::with('users')->paginate(10);
            return view('Admin.Schedule.index')->with(['schedules'=>$schedules]);
        }else{
            $parsedDate = Carbon::parse($date)->format('Y-m-d');
            $schedules=Schedule::with('users')->whereDate('from','like',$parsedDate)->paginate(10);
            return view('Admin.Schedule.index')->with(['schedules'=>$schedules]);
        }
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $doctors=User::whereHas('roles', function($q)
        {
            $q->where('name', 'doctor');
        })->get();

        return view('Admin.Schedule.create')->with(['doctors'=>$doctors]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Schedule::create($request->except('_token'));
        return redirect(route('admin.schedule.index'));

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Schedule::destroy($id);
        return redirect(route('admin.schedule.index'));
    }


}
