@extends('layouts.adminLayout')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md" >
                <h2 class="card-title mb-4">Create a new service</h2>
                <div class="card">
                    <div class="card-body">
                        <form action="{{route('admin.service.store')}}" class="form-control mx-auto border-0"  method="POST">
                            @csrf
                            <label for="name">Name</label>
                            <input name="name" class="form-control" type="text"><br>
                            <label for="duration">Duration</label>
                            <input name="duration" class="form-control" type="text"><br>
                            <label for="price">Price</label>
                            <input name="price" class="form-control" type="text"><br>
                            <button type="submit" class="btn btn-primary mt-2">Create</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
