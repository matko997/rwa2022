@extends('layouts.layout')

@section('content')
    <div class="container">

        <table class="table table-info table-striped mt-5">
            <thead>
            <tr>
                <th scope="col">Reserved at</th>
                <th scope="col">Doctor</th>
                <th scope="col">Start time</th>
                <th scope="col">End time</th>
                <th scope="col">Price</th>
                <th scope="col">Status</th>
                <th scope="col">Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($appointments as $appointment)
                <tr>
                    <td>{{\Illuminate\Support\Carbon::create($appointment->date_created)->utcOffset(120)}}</td>
                    <td>{{$appointment->doctors->name}} {{$appointment->doctors->surname}}</td>
                    <td>{{$appointment->start_time}}</td>
                    <td>{{$appointment->end_time}}</td>
                    <td>{{$appointment->price}}$</td>
                    @if($appointment->canceled)
                        <td>
                            <button class="canceledBtn">
                                canceled
                            </button>
                        </td>
                    @elseif( \Carbon\Carbon::now()->gt($appointment->end_time))
                        <td>
                            <button class="finishedBtn">
                                finished
                            </button>
                        </td>
                    @else
                        <td>
                            <button class="pendingBtn">
                                pending
                            </button>
                        </td>
                    @endif

                    <td>
                        <form action="{{route('patient.cancel',$appointment->id)}}" method="POST">
                            @csrf
                            @if(\Carbon\Carbon::now()->gt($appointment->end_time) || $appointment->canceled)
                                <button type="submit" class="btn btn-sm btn-danger" disabled>Cancel</button>
                            @else
                                <button type="submit" class="btn btn-sm btn-danger">Cancel</button>
                            @endif
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{$appointments->links()}}
    </div>
@endsection
