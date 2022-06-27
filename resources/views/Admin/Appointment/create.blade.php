@extends('layouts.adminLayout')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md">
                <h2 class="card-title mb-4">Create a new appointment</h2>
                <div class="card">
                    <div class="card-body">
                        <form action="{{route('admin.appointment.store')}}" class="form-control mx-auto border-0"
                              method="POST">
                            @csrf
                            <label for="doctor">Doctor</label>
                            <select class="form-select" name="doctor_id" id="doctor_id" required>
                                <option value="">Pick the doctor</option>
                                @foreach($doctors as $doctor)
                                    <option value="{{ $doctor->id }}"> {{ $doctor->name.' '.$doctor->surname }}</option>
                                @endforeach
                            </select>
                            <label for="patient">Patient</label>
                            <select class="form-select" name="patient_id" required>
                                <option value="">Pick the patient</option>
                                @foreach($patients as $patient)
                                    <option
                                        value="{{ $patient->id }}"> {{ $patient->name.' '.$patient->surname }}</option>
                                @endforeach
                            </select>
                            <label for="schedule">Appointment</label>
                            <select class="form-select" name="schedule_id" id="schedule_id" required>
                                <option value="">Pick the appointment</option>
                                @foreach($schedules as $schedule)
                                    <option
                                        value="{{ $schedule->id }}"> {{ $schedule->from.'-'.$schedule->to }}</option>
                                @endforeach
                            </select>
                            <div class="mb-3">
                                @foreach($services as $service)
                                    <div class="form-check">
                                        <input class="form-check-input" name="services[]" type="checkbox"
                                               value="{{$service->id}}"
                                               id="{{$service->name}}">
                                        <label class="form-check-label" for="{{$service->name}}">
                                            {{$service->name}}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            <button type="submit" class="btn btn-primary mt-2">Create</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
