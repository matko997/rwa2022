@extends('layouts.adminLayout')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="float-md-start">Services</h2>
                <a class="btn btn-sm btn-success float-md-end" href="{{route('admin.service.create')}}" role="button">Create</a>
            </div>
        </div>
        <div class="row">
            <div class="col-md">
                <div class="card mt-4">
                    <div class="card-body">
                        <table class="table mt-5">
                            <thead>
                            <tr>
                                <th scope="col">Id</th>
                                <th scope="col">Name</th>
                                <th scope="col">Duration</th>
                                <th scope="col">Price</th>
                                <th scope="col">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($services as $service)
                                <tr>
                                    <th scope="row">{{$service->id}}</th>
                                    <td>{{$service->name}}</td>
                                    <td>{{$service->duration}} minutes</td>
                                    <td>{{$service->price}}</td>
                                    <td>
                                        <a class="btn btn-sm btn-primary" href="{{route('admin.service.edit',$service->id)}}" role="button">Edit</a>
                                        <button type="button" class="btn btn-sm btn-danger" onclick="event.preventDefault(); document.getElementById('delete-service-{{$service->id}}').submit()">
                                            Delete
                                        </button>
                                        <form id="delete-service-{{$service->id}}" action="{{route('admin.service.destroy',$service->id)}}" method="POST" style="display: none">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{$services->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
