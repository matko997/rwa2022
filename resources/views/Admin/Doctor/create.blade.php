@extends('layouts.adminLayout')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md" >
                <h2 class="card-title mb-4">Create a new doctor</h2>
                <div class="card">
                        <div class="card-body">
                        <form action="{{route('admin.doctor.store')}}" class="form-control mx-auto border-0"  method="POST">
                            @include('Admin.Partials.form',['create'=>true])
                            <button type="submit" class="btn btn-primary mt-2">Create</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
