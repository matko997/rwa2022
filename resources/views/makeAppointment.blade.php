@extends('layouts.layout')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md">
                <h2 class="card-title mb-4 text-black-50">Make new appointment</h2>
                <div class="card text-dark bg-light mb-3">
                    <div class="card-body">
                        <form action="{{route('patient.appointment.store')}}"
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
                                        </label>
                                    </div>
                                @endforeach
                                <label for="schedule">Available date</label>
                                <select class="form-select" id="date" required>
                                    <option value="">Pick the date</option>
                                    @foreach($schedulesDayDistinct as $scheduleDay)
                                        <option
                                            value="{{ $scheduleDay }}"> {{ $scheduleDay }}</option>
                                    @endforeach
                                </select>
                                <label for="schedule">Available time</label>
                                <select class="form-select" name="schedule" id="time" required>
                                    <option value="">Pick the time</option>
                                    @foreach($schedules as $schedule)
                                        <option
                                            value="{{ $schedule->id }}"> {{ \Carbon\Carbon::parse($schedule->from)->format('H:i') }}
                                        </option>
                                    @endforeach
                                </select>
                                <input name="doctorId" type="hidden" value="{{$doctorId}}">
                                <button type="submit" class="btn btn-primary mt-2" id="makeAppointment">Create</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
