<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dental Clinic</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<style>
    body{
        background-image:url({{url('images/background.jpg')}});
        background-repeat: repeat-y;
    }
</style>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-info">
    <div class="container-fluid">
        <a class="navbar-brand " href="/" style="font-family:Cambria, Cochin, Georgia, Times, 'Times New Roman', serif; font-size: x-large; font-weight: 500;">Dental clinic</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="/">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link"  href="/about">About</a>
                </li>

            </ul>
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                @guest()
                    <li class="nav-item">
                        <a class="nav-link" href="/signup"><span><i class="fa fa-user"></i>Sign Up</span> </a>
                    </li>

                    <li class="nav-item ">
                        <a class="nav-link" href="/login"><span><i class="fa fa-sign-in" aria-hidden="true"></i>Login</span> </a>
                    </li>
                @else
                    <div class="d-flex">
                        <form method="POST" action="/logout">
                            @csrf
                            <span class="small text-uppercase fw-bold text-align mt-2 mr-2">Welcome, {{auth()->user()->name}}!</span>
                            <button type="submit" class="btn btn-outline-dark">Logout</button>
                        </form>



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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</html>
