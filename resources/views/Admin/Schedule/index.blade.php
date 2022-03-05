@extends('layouts.adminLayout')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2 class="float-md-start">Schedules</h2>
                <a class="btn btn-sm btn-success float-md-end" href="{{route('admin.schedule.create')}}" role="button">Create</a>
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
                                <th scope="col">Doctor</th>
                                <th scope="col">From</th>
                                <th scope="col">To</th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($schedules as $schedule)
                                <tr>
                                    <td>{{$schedule->id}}</td>
                                    <td>{{$schedule->users->name.' '.$schedule->users->surname}}</td>
                                    <td>{{$schedule->from}}</td>
                                    <td>{{$schedule->to}}</td>
                                    <td>
                                        <a class="btn btn-sm btn-primary" href="{{route('admin.schedule.edit',$schedule->id)}}" role="button">Edit</a>
                                        <button type="button" class="btn btn-sm btn-danger" onclick="event.preventDefault(); document.getElementById('delete-schedule-{{$schedule->id}}').submit()">
                                            Delete
                                        </button>
                                        <form id="delete-schedule-{{$schedule->id}}" action="{{route('admin.schedule.destroy',$schedule->id)}}" method="POST" style="display: none">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
