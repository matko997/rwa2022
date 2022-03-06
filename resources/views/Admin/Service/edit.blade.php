@extends('layouts.adminLayout')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md" >
                <h2 class="card-title mb-4">Edit a service</h2>
                <div class="card">
                    <div class="card-body">
                        <form action="{{route('admin.service.update',$service->id)}}" class="form-control mx-auto border-0"  method="POST">
                            @csrf
                            @method('PATCH')
                            <label for="name">Name</label>
                            <input name="name" class="form-control" type="text" value="@isset($service){{$service->name}}@endisset"><br>
                            <label for="duration">Duration</label>
                            <input name="duration" class="form-control" type="text" value="@isset($service){{$service->duration}}@endisset"><br>
                            <label for="price">Price</label>
                            <input name="price" class="form-control" type="text" value="@isset($service){{$service->price}}@endisset"><br>
                            <button type="submit" class="btn btn-primary mt-2">Edit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
