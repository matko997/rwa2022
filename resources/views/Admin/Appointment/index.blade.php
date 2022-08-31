@extends('layouts.adminLayout')
@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                @if(\Illuminate\Support\Facades\Auth::user()->hasAnyRole('admin'))
                    <h2 class="float-md-start">Appointments</h2>
                @else
                    <h2 class="float-md-start">My Appointments</h2>
                @endif

                <a class="btn btn-sm btn-success float-md-end" href="{{route('admin.appointment.create')}}"
                   role="button">Create</a>
            </div>
            <form class="mx-auto border-0" method="GET" action="{{route('admin.appointment.index',[$date_picked ?? ''])}}">
                <div class="row justify-content-lg-start mt-4 w-50">
                    <div class="col-sm-6 p-0">
                        <label for="date">Date</label>
                        <input class="form-control" type="date" name="datePicked" id="datePicked">
                    </div>
                    <div class="col-sm-6 p-0">
                        <button class="btn btn-md btn-info text-white mt-4 ms-1" type="submit">Filter</button>
                    </div>
                </div>
            </form>
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
                                        <p><strong>Services:</strong>
                                        <ul id="appointment-service"></ul>
                                        </p>
                                        <p><strong>Total price:</strong> <span id="appointment-price"></span><i>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                     fill="currentColor" class="bi bi-currency-dollar"
                                                     viewBox="3 2 14 16">
                                                    <path
                                                        d="M4 10.781c.148 1.667 1.513 2.85 3.591 3.003V15h1.043v-1.216c2.27-.179 3.678-1.438 3.678-3.3 0-1.59-.947-2.51-2.956-3.028l-.722-.187V3.467c1.122.11 1.879.714 2.07 1.616h1.47c-.166-1.6-1.54-2.748-3.54-2.875V1H7.591v1.233c-1.939.23-3.27 1.472-3.27 3.156 0 1.454.966 2.483 2.661 2.917l.61.162v4.031c-1.149-.17-1.94-.8-2.131-1.718H4zm3.391-3.836c-1.043-.263-1.6-.825-1.6-1.616 0-.944.704-1.641 1.8-1.828v3.495l-.2-.05zm1.591 1.872c1.287.323 1.852.859 1.852 1.769 0 1.097-.826 1.828-2.2 1.939V8.73l.348.086z"/>
                                                </svg>
                                            </i></p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" id="close-modal"
                                                data-bs-dismiss="modal">Close
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
