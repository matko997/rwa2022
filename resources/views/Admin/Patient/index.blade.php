@extends('layouts.adminLayout')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2 class="float-md-start">Patients</h2>
                <a class="btn btn-sm btn-success float-md-end" href="{{route('admin.patient.create')}}" role="button">Create</a>
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
                            @foreach($patients as $patient)
                                <tr>
                                    <th scope="row">{{$patient->id}}</th>
                                    <td>{{$patient->name}}</td>
                                    <td>{{$patient->surname}}</td>
                                    <td>{{$patient->gender}}</td>
                                    <td>{{$patient->email}}</td>
                                    <td>
                                        <a class="btn btn-sm btn-primary" href="{{route('admin.patient.edit',$patient->id)}}" role="button">Edit</a>
                                        <button type="button" class="btn btn-sm btn-danger" onclick="event.preventDefault(); document.getElementById('delete-patient-{{$patient->id}}').submit()">
                                            Delete
                                        </button>
                                        <form id="delete-patient-{{$patient->id}}" action="{{route('admin.patient.destroy',$patient->id)}}" method="POST" style="display: none">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{$patients->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
