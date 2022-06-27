<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="{!! asset('app.css') !!}" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script type="text/javascript" charset="utf8"
            src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
</head>
<body>
<div class="container-fluid">
    <div class="row flex-nowrap">
        <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-dark">
            <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100">
                <a href="{{route('admin.')}}"
                   class="d-flex align-items-center pb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                    <span class="fs-2 d-none d-sm-inline">Dashboard</span>
                </a>
                <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start" id="menu">

                    <li>
                        <a href="#submenu1" data-bs-toggle="collapse" class="nav-link px-0 align-middle text-white">
                            <i class="fs-4 bi-speedometer2"></i> <span class="ms-1 d-none d-sm-inline">Users</span> </a>
                        <ul class="collapse show nav flex-column ms-1" id="submenu1" data-bs-parent="#menu">
                            <li class="w-100">
                                <a href="{{route('admin.doctor.index')}}" class="nav-link px-0 text-white"> <span
                                        class="d-none d-sm-inline">Doctors</span> </a>
                            </li>
                            <li>
                                <a href="{{route('admin.patient.index')}}" class="nav-link px-0 text-white"> <span
                                        class="d-none d-sm-inline">Patients</span> </a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="{{route('admin.schedule.index')}}" class="nav-link px-0 align-middle text-white">
                            <i class="fs-4 bi-table"></i> <span class="ms-1 d-none d-sm-inline">Schedules</span></a>
                    </li>
                    <li>
                        <a href="{{route('admin.appointment.index')}}" class="nav-link px-0 align-middle text-white">
                            <i class="fs-4 bi-table"></i> <span class="ms-1 d-none d-sm-inline">Appointments</span></a>
                    </li>

                    <li>
                        <a href="{{route('admin.service.index')}}" class="nav-link px-0 align-middle text-white">
                            <i class="fs-4 bi-table"></i> <span class="ms-1 d-none d-sm-inline">Services</span></a>
                    </li>

                    <li>
                        <a href="#" class="nav-link px-0 align-middle text-white">
                            <i class="fs-4 bi-people"></i> <span class="ms-1 d-none d-sm-inline">Roles</span> </a>
                    </li>
                </ul>

            </div>
        </div>
        <div class="col py-3">
            @yield('content')
        </div>
    </div>
</div>
</body>
<script>
    $(document).ready(function () {
        $('#doctor_id').change(function () {
            let doctor_id = $(this).val();
            $.ajax({
                url: '/admin/appointment/getDoctorId',
                type: 'post',
                data: 'doctor_id=' + doctor_id + '&_token={{csrf_token()}}',
                success: function (result) {
                    $('#schedule_id').html(result);
                }
            })
        });
    });

    $(document).ready(function () {
        $('body').on('click', '#show-appointment', function () {
            var userURL = $(this).data('url');
            $.get(userURL, function (data) {
                $('#userShowModal').modal('show');
                $('#appointment-id').text(data.id);
                $('#appointment-doctor').text(data.doctors.name);
                $('#appointment-patient').text(data.patients.name);
                $('#appointment-start').text(data.start_time);
                $('#appointment-end').text(data.end_time);
                $('#appointment-price').text(data.price);

                for(var i=0;i<data.services.length;i++){
                    var ul = document.getElementById("appointment-service");
                    var li = document.createElement("li");
                    li.appendChild(document.createTextNode(data.services[i].name));
                    ul.appendChild(li);
                }




                console.log(data);

            })
        });
    });
</script>
</html>
