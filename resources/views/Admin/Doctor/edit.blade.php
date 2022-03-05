@extends('layouts.adminLayout')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md" >
                <h2 class="card-title mb-4">Edit a doctor</h2>
                <div class="card">
                    <div class="card-body">
                        <form action="{{route('admin.doctor.update',$doctor->id)}}" class="form-control mx-auto border-0"  method="POST">
                            @method('PATCH')
                            @include('Admin.Partials.form')
                            <button type="submit" class="btn btn-primary mt-2">Edit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
