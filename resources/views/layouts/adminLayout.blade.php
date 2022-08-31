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
    <style>
        .pendingBtn {
            width: 100px;
            height: 30px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            background-color: #008CBA;
            color: white;
            border-radius: 6px;
            padding: 3px 3px;
            border: none;
            cursor: none;
        }

        .canceledBtn {
            width: 100px;
            height: 30px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            background-color: #f44336;
            color: white;
            border-radius: 6px;
            padding: 3px 3px;
            border: none;
            cursor: none;
        }

        .finishedBtn {
            width: 100px;
            height: 30px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            background-color: #5aeea9;
            color: white;
            border-radius: 6px;
            padding: 3px 3px;
            border: none;
            cursor: none;
        }
    </style>
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
                    @can('is-admin')
                        <li>
                            <a href="#submenu1" data-bs-toggle="collapse" class="nav-link px-0 align-middle text-white">
                                <i class="fs-4 bi-speedometer2"></i> <span class="ms-1 d-none d-sm-inline">Users</span>
                            </a>
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
                    @endcan
                    <li>
                        <a href="{{route('admin.schedule.index')}}" class="nav-link px-0 align-middle text-white">
                            <i class="fs-4 bi-table"></i>
                            @if(\Illuminate\Support\Facades\Auth::user()->hasAnyRole('admin'))
                                Schedules</span>
                            @else
                                <span class="ms-1 d-none d-sm-inline">My schedules</span>
                            @endif
                        </a>
                    </li>
                    <li>
                        <a href="{{route('admin.appointment.index')}}" class="nav-link px-0 align-middle text-white">
                            <i class="fs-4 bi-table"></i> @if(\Illuminate\Support\Facades\Auth::user()->hasAnyRole('admin'))
                                Appointments</span>
                            @else
                                <span class="ms-1 d-none d-sm-inline">My appointments</span>
                            @endif</a>
                    </li>
                    @can('is-admin')
                        <li>
                            <a href="{{route('admin.service.index')}}" class="nav-link px-0 align-middle text-white">
                                <i class="fs-4 bi-table"></i> <span class="ms-1 d-none d-sm-inline">Services</span></a>
                        </li>
                    @endcan


                    <span
                        class="h4 text-align mt-2 mr-2">{{\Illuminate\Support\Facades\Auth::user()->name}}
                    </span>
                    <form method="POST" action="{{route('logout')}}" class="position-relative">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-primary">Logout
                        </button>
                    </form>
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
                    $('#date').html(result);
                }
            })
        });
    });

    $(document).ready(function () {
        $('#date').change(function () {
            var services = [];

            $('.services:checked').each(function () {
                services.push($(this).val());
            })

            let date = $('#date').find(":selected").text();
            let doctor_ID = $('#doctor_id').find(":selected").val();

            $.ajax({
                url: '/admin/appointment/getDate',
                type: 'post',
                data: 'from=' + date + '&doctor_id=' + doctor_ID + '&services=' + services + '&_token={{csrf_token()}}',
                success: function (result) {
                    $('#time').html(result);
                }
            })
        });
    });
    $(document).ready(function () {
        $('.services').on('click', function () {
            document.getElementById("date").selectedIndex = 0;
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

                for (var i = 0; i < data.services.length; i++) {
                    var ul = document.getElementById("appointment-service");
                    var li = document.createElement("li");
                    li.appendChild(document.createTextNode(data.services[i].name));
                    ul.appendChild(li);
                }
                console.log(data);
            })
        });
    });

    $(document).ready(function () {
        $('body').on('click', '#close-modal', function () {
            $('#appointment-service').empty();
        });
    });

    $(document).ready(function () {
        $('#checkBtn').click(function () {
            checked = $("input[type=checkbox]:checked").length;

            if (!checked) {
                alert("You must check at least one service.");
                return false;
            }

        });
    });


</script>
</html>
