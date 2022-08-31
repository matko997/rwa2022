@extends('layouts.layout')

@section('content')
    <div class="container rounded bg-light mt-5 mb-5">
        <div class="border-right">
            <div class="p-3 py-5">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="text-right">Profile Settings</h4>
                </div>
                <form action="{{route('patient.info.store')}}" class="form-control mx-auto border-0" method="POST">
                    @csrf
                    <div class="row mt-2">
                        <div class="col-md-6"><label class="labels">Name</label><input type="text" class="form-control"
                                                                                       placeholder="first name"
                                                                                       value="{{$patient->name}}" name="name">
                        </div>
                        <div class="col-md-6"><label class="labels">Surname</label><input type="text"
                                                                                          class="form-control"
                                                                                          value="{{$patient->surname}}"
                                                                                          placeholder="surname"
                                                                                          name="surname">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12"><label class="labels">Mobile Number</label><input type="text"
                                                                                                 class="form-control"
                                                                                                 placeholder="enter phone number"
                                                                                                 value="{{$patient->phoneNumber}}"
                                                                                                 name="phoneNumber">
                        </div>
                        <div class="col-md-12"><label class="labels">Email</label><input type="text"
                                                                                         class="form-control"
                                                                                         placeholder="enter address line 1"
                                                                                         value="{{$patient->email}}"
                                                                                         name="email">
                        </div>

                    </div>
                    <div class="mt-5 text-center">
                        <button class="btn btn-primary profile-button" type="submit">Save Profile</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
