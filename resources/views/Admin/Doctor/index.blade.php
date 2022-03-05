@extends('layouts.adminLayout')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2 class="float-md-start">Doctors</h2>
                <a class="btn btn-sm btn-success float-md-end" href="{{route('admin.doctor.create')}}" role="button">Create</a>
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
                                <th scope="col">Name</th>
                                <th scope="col">Surname</th>
                                <th scope="col">Gender</th>
                                <th scope="col">Email</th>
                                <th scope="col">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($doctors as $doctor)
                                <tr>
                                    <th scope="row">{{$doctor->id}}</th>
                                    <td>{{$doctor->name}}</td>
                                    <td>{{$doctor->surname}}</td>
                                    <td>{{$doctor->gender}}</td>
                                    <td>{{$doctor->email}}</td>
                                    <td>
                                        <a class="btn btn-sm btn-primary" href="{{route('admin.doctor.edit',$doctor->id)}}" role="button">Edit</a>
                                        <button type="button" class="btn btn-sm btn-danger" onclick="event.preventDefault(); document.getElementById('delete-doctor-{{$doctor->id}}').submit()">
                                            Delete
                                        </button>
                                        <form id="delete-doctor-{{$doctor->id}}" action="{{route('admin.doctor.destroy',$doctor->id)}}" method="POST" style="display: none">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{$doctors->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
