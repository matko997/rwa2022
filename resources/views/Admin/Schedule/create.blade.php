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
                                <label for="startDate">Start</label>
                                <input name="from" class="form-control" type="datetime-local" />
                                <label for="startDate">End</label>
                                <input name="to" class="form-control" type="datetime-local" />
                            <label></label>
                            <select class="form-select" name="user_id" required>
                                <option value="">Pick a doctor</option>
                                @foreach($doctors as $doctor)
                                    <option value="{{ $doctor->id }}"> {{ $doctor->name }}</option>
                                @endforeach
                            </select>
                            <button type="submit" class="btn btn-primary mt-2">Create</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
