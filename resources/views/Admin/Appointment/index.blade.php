@extends('layouts.adminLayout')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="float-md-start">Appointments</h2>
                <a class="btn btn-sm btn-success float-md-end" href="{{route('admin.appointment.create')}}" role="button">Create</a>
            </div>
        </div>
        <div class="row">
            <div class="col-md">
                <div class="card mt-4">
                    <div class="card-body">
                        <table class="table mt-5">
                            <thead>
                            <tr>
                                <th scope="col">Id</th>
                                <th scope="col">Patient</th>
                                <th scope="col">Doctor</th>
                                <th scope="col">Service</th>
                                <th scope="col">Date</th>
                                <th scope="col">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($appointments as $appointment)
                                <tr>
                                    <th scope="row">{{$appointment->id}}</th>
                                    <td>{{$appointment->patients->name}}</td>
                                    <td>{{$appointment->doctors->name}} </td>
                                    <td>{{$appointment->services->name}}</td>
                                    <td>{{$appointment->start_time}}</td>
                                    <td>
                                        <a class="btn btn-sm btn-primary" href="{{route('admin.appointment.edit',$appointment->id)}}" role="button">Edit</a>
                                        <button type="button" class="btn btn-sm btn-danger" onclick="event.preventDefault(); document.getElementById('delete-appointement-{{$appointment->id}}').submit()">
                                            Delete
                                        </button>
                                        <form id="delete-aappointment-{{$appointment->id}}" action="{{route('admin.appointment.destroy',$appointment->id)}}" method="POST" style="display: none">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{$appointments->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
