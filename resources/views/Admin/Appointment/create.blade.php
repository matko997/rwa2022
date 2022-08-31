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
                            <div class="mb-3">
                                <label for="service">Pick a services you want to make appointment for:</label>
                                <br><br>
                                @foreach($services as $service)
                                    <div class="form-check">
                                        <input class="form-check-input services" name="services[]" type="checkbox"
                                               value="{{$service->id}}"
                                               id="{{$service->name}}">
                                        <label class="form-check-label" for="{{$service->name}}">

                                            {{$service->name}}
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                 fill="currentColor" class="bi bi-clock-fill" viewBox="0 0 16 16">
                                                <path
                                                    d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z"/>
                                            </svg>
                                            </svg>{{$service->duration}} <i>min</i>
                                            <b><i>{{$service->price}}</i></b>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="30"
                                                 fill="currentColor" class="bi bi-currency-dollar" viewBox="4 3 14 14">
                                                <path
                                                    d="M4 10.781c.148 1.667 1.513 2.85 3.591 3.003V15h1.043v-1.216c2.27-.179 3.678-1.438 3.678-3.3 0-1.59-.947-2.51-2.956-3.028l-.722-.187V3.467c1.122.11 1.879.714 2.07 1.616h1.47c-.166-1.6-1.54-2.748-3.54-2.875V1H7.591v1.233c-1.939.23-3.27 1.472-3.27 3.156 0 1.454.966 2.483 2.661 2.917l.61.162v4.031c-1.149-.17-1.94-.8-2.131-1.718H4zm3.391-3.836c-1.043-.263-1.6-.825-1.6-1.616 0-.944.704-1.641 1.8-1.828v3.495l-.2-.05zm1.591 1.872c1.287.323 1.852.859 1.852 1.769 0 1.097-.826 1.828-2.2 1.939V8.73l.348.086z"/>
                                            </svg>

                                        </label>
                                    </div>
                                @endforeach
                            </div>
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
                            <label for="schedule">Date</label>
                            <select class="form-select" id="date" required>
                                <option value="">Pick the date</option>
                                @foreach($schedules as $schedule)
                                    <option
                                        value="{{ $schedule->from }}"> {{ \Carbon\Carbon::parse($schedule->from)->format('Y-m-d') }}</option>
                                @endforeach
                            </select>
                            <label for="schedule">Time</label>
                            <select class="form-select" name="schedule" id="time" required>
                                <option value="">Pick the time</option>
                                @foreach($schedules as $schedule)
                                    <option
                                        value="{{ $schedule->id }}"> {{ \Carbon\Carbon::parse($schedule->from)->format('H:i') }}</option>
                                @endforeach
                            </select>

                            <button type="submit" class="btn btn-primary mt-2" id="checkBtn">Create</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
