@extends('layouts.adminLayout')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md" >
                <h2 class="card-title mb-4">Create a new schedule</h2>
                <div class="card">
                    <div class="card-body">
                        <form action="{{route('admin.schedule.store')}}" class="form-control mx-auto border-0"  method="POST">
                            @csrf
                            <div class="form-group">
                                <div class='input-group date' id='datetimepicker1'>
                                    <input type='text' class="form-control" />
                                    <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                                <button type="submit" class="btn btn-primary mt-2">Create</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
