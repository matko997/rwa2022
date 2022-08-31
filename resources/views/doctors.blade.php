@extends('layouts.layout')

@section('content')
    <div class="container">

        <table class="table table-info table-striped mt-5">
            <thead>
            <tr>
                <th scope="col">First name</th>
                <th scope="col">Last name</th>
                <th scope="col">Email</th>
                <th scope="col">Appointment</th>
            </tr>
            </thead>
            <tbody>
            @foreach($doctors as $doctor)
                <tr>
                    <td>{{$doctor->name}}</td>
                    <td>{{$doctor->surname}}</td>
                    <td>{{$doctor->email}}</td>
                    <td>
                        <form action="{{route('patient.makeAppointment',$doctor->id)}}"  method="POST">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-primary">Make appointment</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{$doctors->links()}}
    </div>

@endsection
