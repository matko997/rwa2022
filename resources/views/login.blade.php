@extends('layouts.layout')


@section('content')
<div class="container  ">
    <div class="row">
        <div class="col-md mt-5 ">
            <form action="{{route('login')}}" method="POST" class="form-control mx-auto " style="width: 70%;">
                @csrf
                <h2 class="text-center">Login</h2>
                <label for="email" class="form-label">Email</label>
                <input type="text" class="form-control" id="email" name="email" placeholder="Enter email">
                @error('email')
                <p class="text-danger small mt-1">{{$message}}</p>
                @enderror
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Enter password">

                <button type="submit" class="btn btn-primary mt-2">Login</button>
            </form>
        </div>
    </div>
</div>


@endsection




