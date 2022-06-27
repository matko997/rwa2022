@extends('layouts.adminLayout')
@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="float-md-start">Appointments</h2>
                <a class="btn btn-sm btn-success float-md-end" href="{{route('admin.appointment.create')}}"
                   role="button">Create</a>
            </div>
        </div>
        <div class="row">
            <div class="col-md">
                <div class="card mt-4">
                    <div class="card-body">
                        <table class="table mt-5" id="example">
                            <thead>
                            <tr>
                                <th scope="col">Id</th>
                                <th scope="col">Patient</th>
                                <th scope="col">Doctor</th>
                                <th scope="col">Status</th>
                                <th scope="col">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($appointments as $appointment)
                                <tr>
                                    <th scope="row">{{$appointment->id}}</th>
                                    <td>{{$appointment->patients->name.' '.$appointment->patients->surname}}</td>
                                    <td>{{$appointment->doctors->name.' '.$appointment->doctors->surname}} </td>
                                    <td>
                                        <a class="btn btn-sm btn-primary"
                                           href="{{route('admin.appointment.edit',$appointment->id)}}"
                                           role="button">@if($appointment->canceled)
                                                canceled
                                            @else
                                                pending
                                            @endif</a>
                                    </td>
                                    <td>
                                        <a
                                            href="javascript:void(0)"
                                            id="show-appointment"
                                            data-url="{{ route('admin.appointment.show', $appointment->id) }}"
                                            class="btn btn-sm btn-success"
                                        >Show</a>
                                        <button type="button" class="btn btn-sm btn-danger"
                                                onclick="event.preventDefault(); document.getElementById('delete-appointment-{{$appointment->id}}').submit()">
                                            Delete
                                        </button>
                                        <form id="delete-appointment-{{$appointment->id}}"
                                              action="{{route('admin.appointment.destroy',$appointment->id)}}"
                                              method="POST" style="display: none">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{$appointments->links()}}
                        <div class="modal fade" id="userShowModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                             aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Appointment details</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p><strong>ID:</strong> <span id="appointment-id"></span></p>
                                        <p><strong>Doctor:</strong> <span id="appointment-doctor"></span></p>
                                        <p><strong>Patient:</strong> <span id="appointment-patient"></span></p>
                                        <p><strong>Start time:</strong> <span id="appointment-start"></span></p>
                                        <p><strong>End time:</strong> <span id="appointment-end"></span></p>
                                        <p><strong>Services:</strong></p>
                                        <ul id="appointment-service"></ul>
                                        <p><strong>Total price:</strong> <span id="appointment-price"></span></p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
