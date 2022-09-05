@csrf
<label for="name" class="form-label">Name</label>
<input type="text" class="form-control" id="name" name="name" placeholder="Enter name" value="{{old('name')}}@isset($doctor){{$doctor->name}}@endisset @isset($patient){{$patient->name}}@endisset">
@error('name')
<p class="text-danger small mt-1">{{$message}}</p>
@enderror
<label for="surname" class="form-label">Surname</label>
<input type="text" class="form-control" id="surname" name="surname" placeholder="Enter surname" value="{{old('surname')}}@isset($doctor){{$doctor->surname}}@endisset @isset($patient){{$patient->surname}}@endisset">
@error('surname')
<p class="text-danger small mt-1">{{$message}}</p>
@enderror
<label for="email" class="form-label">Email</label>
<input type="email" class="form-control" id="email" name="email" placeholder="Enter email" value="{{old('email')}}@isset($doctor){{$doctor->email}}@endisset @isset($patient){{$patient->email}}@endisset">
@error('email')
<p class="text-danger small mt-1">{{$message}}</p>
@enderror
<label for="phoneNumber" class="form-label">Phone number</label>
<input type="text" class="form-control" id="phoneNumber" name="phoneNumber" placeholder="Enter phone number" value="{{old('phoneNumber')}}@isset($doctor){{$doctor->phoneNumber}}@endisset @isset($patient){{$patient->phoneNumber}}@endisset">
@error('phoneNumber')
<p class="text-danger small mt-1">{{$message}}</p>
@enderror
<label for="gender" class="form-label">Gender</label>
<div class="form-check">
    <input class="form-check-input" type="radio" name="gender" id="radioGender1" value="M" @isset($doctor){{$doctor->gender=='M' ? 'checked' : ""}}@endisset @isset($patient){{$patient->gender=='M' ? 'checked' : ""}}@endisset>
    <label class="form-check-label" for="radioGender1">
        M
    </label>
</div>
<div class="form-check">
    <input class="form-check-input" type="radio" name="gender" id="radioGender2" value="F" @isset($doctor){{$doctor->gender=='F' ? 'checked' : ""}}@endisset @isset($patient){{$patient->gender=='F' ? 'checked' : ""}}@endisset>
    <label class="form-check-label" for="radioGender2" >
        F
    </label>
</div>
@error('gender')
<p class="text-danger small mt-1">{{$message}}</p>
@enderror
@isset($create)
<label for="password" class="form-label">Password</label>
<input type="password" class="form-control" id="password" name="password" placeholder="Enter password">
@error('password')
<p class="text-danger small mt-1">{{$message}}</p>
@enderror
@endisset


