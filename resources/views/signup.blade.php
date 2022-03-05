@extends('layouts.layout')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md mt-5" >
                <div class="card">
                    <h2 class="card-title mt-2 m-lg-2">Register</h2>
                    <div class="card-body">
                        <form action="/signup" class="form-control mx-auto border-0"  method="POST">
                            @csrf
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter name" value="{{old('name')}}">
                            @error('name')
                            <p class="text-danger small mt-1">{{$message}}</p>
                            @enderror
                            <label for="surname" class="form-label">Surname</label>
                            <input type="text" class="form-control" id="surname" name="surname" placeholder="Enter surname" value="{{old('surname')}}">
                            @error('surname')
                            <p class="text-danger small mt-1">{{$message}}</p>
                            @enderror
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" value="{{old('email')}}">
                            @error('email')
                            <p class="text-danger small mt-1">{{$message}}</p>
                            @enderror
                            <label for="gender" class="form-label">Gender</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="gender" id="radioGender1" value="M" {{old('gender')=='M'?'checked':''}}>
                                <label class="form-check-label" for="radioGender1">
                                    M
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="gender" id="radioGender2" value="F" {{old('gender')=='F'?'checked':''}}>
                                <label class="form-check-label" for="radioGender2" >
                                    F
                                </label>
                            </div>
                            @error('gender')
                            <p class="text-danger small mt-1">{{$message}}</p>
                            @enderror
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter password">
                            @error('password')
                            <p class="text-danger small mt-1">{{$message}}</p>
                            @enderror
                            <label for="rPassword" class="form-label">Confirm password</label>
                            <input type="password" class="form-control" id="rPassword" name="rPassword" placeholder="Enter password again">
                            <button type="submit" class="btn btn-primary mt-2">Register</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

