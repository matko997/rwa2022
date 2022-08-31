<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dental Clinic</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js"
            integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT"
            crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

</head>
<style>
    body {
        background-image: url({{url('images/background.jpg')}});
        background-repeat: repeat-y;
    }
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
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-info">
    <div class="container-fluid">
        <a class="navbar-brand " href="{{route('home')}}"
           style="font-family:Cambria, Cochin, Georgia, Times, 'Times New Roman', serif; font-size: x-large; font-weight: 500;">Dental
            clinic</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="{{route('home')}}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('about')}}">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('doctors')}}">Doctors</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('services')}}">Price list</a>
                </li>

            </ul>
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                @guest()
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('signupForm')}}"><span><i
                                    class="fa fa-user"></i>Sign Up</span> </a>
                    </li>

                    <li class="nav-item ">
                        <a class="nav-link" href="{{route('loginForm')}}"><span><i class="fa fa-sign-in"
                                                                                   aria-hidden="true"></i>Login</span>
                        </a>
                    </li>
                @else
                    <div class="btn-group dropstart">
                        <button type="button" class="btn btn-info dropdown-toggle" data-bs-toggle="dropdown"
                                aria-expanded="false">
                            <span class="small text-align mt-2 mr-2"> {{auth()->user()->name}}</span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{route('patient.appointments')}}">My appointments</a></li>
                            <li><a class="dropdown-item" href="{{route('patient.info')}}">My profile</a></li>
                            <form method="POST" action="{{route('logout')}}">
                                @csrf
                                <button class="dropdown-item" type="submit">
                                    Logout
                                </button>
                            </form>
                        </ul>
                    </div>
                @endguest
            </ul>

        </div>
    </div>
</nav>


<br> <br>


@yield('content')


<br><br>

<div class="container-fluid bg-info fixed-bottom">
    <div class="row">
        <div class="col-md">
            <p class="text-center m-2"><b>All rights reserved M&M ©2021</b></p>
        </div>
    </div>
</div>
</body>
<script>
    $(document).ready(function () {
        $('#date').change(function () {
            var services = [];

            $('.services:checked').each(function () {
                services.push($(this).val());
            })

            let date = $('#date').find(":selected").text();

            $.ajax({
                url: '/patient/appointment/time',
                type: 'post',
                data: 'from=' + date + '&services=' + services + '&_token={{csrf_token()}}',
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
        $('#makeAppointment').click(function () {
            checked = $("input[type=checkbox]:checked").length;

            if (!checked) {
                alert("You must check at least one service.");
                return false;
            }

        });
    });
</script>
</html>
