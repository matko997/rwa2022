@extends('layouts.adminLayout')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2 class="float-md-start">Schedules</h2>
                <a class="btn btn-sm btn-success float-md-end" href="{{route('admin.schedule.create')}}" role="button">Create</a>
            </div>
        </div>

        <form class="mx-auto border-0" method="GET" action="{{url('admin/schedule/',Request::input('datePicked'))}}">
            <div class="row justify-content-lg-start mt-4 w-50">
                <div class="col-sm-6 p-0">
                    <label for="date">Date</label>
                    <input class="form-control" type="date" name="datePicked">
                </div>
                <div class="col-sm-6 p-0">
                    <button class="btn btn-md btn-info text-white mt-4 ms-1" type="submit">Filter</button>
                </div>
            </div>
        </form>


        <div class="row">
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
                                    <td>{{ \Carbon\Carbon::parse($schedule->from)->format('H:i') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($schedule->to)->format('H:i') }}</td>
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
                        {{$schedules->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
