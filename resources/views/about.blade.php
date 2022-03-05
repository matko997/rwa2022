@extends('layouts.layout')


@section('content')
<h1 class="text-center text-black">About us</h1>

<div class="container">
    <div class="row">
        <div class="col-md bg-info rounded-3 m-2">
            <div class="image-wrapper" style="margin: 0 auto;">
                <img src="./images/matko.jpg" alt="Matko" class="rounded mx-auto d-block" style="clip-path: circle();  ">
            </div>
            <div class="about text-center">
                <div class="name"><b>Ime:Matko</b></div>
                <div class="surname"><b>Prezime:Dugandžić</b></div>
                <div class="birthday"><b>Datum rođenja:29/04/1997</b></div>
                <div class="email"><b>Email:matko.dugandzic@fsre.sum.ba</b></div>
            </div>
            <div class="about-text text-center">
                <br>
                <p>Student sam treće godine računarstva na Fakultetu strojarstva, računarstva i elektrotehnike u Mostaru.
                    Dolazim iz Ljubuškog, volim gaming i tehnologiju opcenito, u slobodno vrijeme gledam filmove.
                </p>
            </div>
        </div>
        <div class="col-md bg-info rounded-3 m-2">
            <div class="image-wrapper">
                <img src="./images/mijo.jpg" alt="Mijo" class="rounded mx-auto d-block" style="clip-path: circle(); ">
            </div>
            <div class="about text-center">
                <div class="name"><b>Ime:Mijo</b></div>
                <div class="surname"><b>Prezime:Kozina</b></div>
                <div class="birthday"><b>Datum rođenja:10/10/1998</b></div>
                <div class="email"><b>Email:mijo.kozina@fsre.sum.ba</b></div>
            </div>
            <div class="about-text text-center">
                <br>
                <p>Student sam treće godine računarstva na Fakultetu strojarstva, računarstva i elektrotehnike u Mostaru.
                    Dolazim iz Ljubuškog, slobodno vrijeme provodim uz dobre filmove i serije.
                </p>
            </div>

        </div>
    </div>
</div>
<br> <br>
<h1 class="text-center text-black">About project</h1>
<div class="container">
    <div class="row">
        <div class="col-md bg-info rounded-3 m-2 p-2">
            <h5 class="text-center">Zašto ovaj projekt?</h5>
            <p class="about-text text-center">
                Ovaj projekt nam se čini kao odlična prilika da naučimo osnovne koncepte web programiranja
                kao i tehnologija koje se za isto koriste, također smatramo da jako mali broj dentalnih ordinacija posjeduje sustav za online narudžbe i da bi takvo nešto bilo od velike koristi.
                Više o projektu možete pronaći u <a class="vizija" href="https://drive.google.com/file/d/1zN2t6yMwZ3X0w74FgyLLbPZP4WnMinMt/view?usp=sharing">Viziji</a>
            </p>
        </div>
        <div class="col-md bg-info rounded-3 m-2 p-2">
            <h5 class="text-center">Tehnologije koje cemo koristiti?</h5>
            <p class="about-text text-center">
                Najvjerojatnije ce to biti Laravel <span><img src="./images/laravel.png" alt="Laravel" class="img-responsive"> i Vue.js <img src="./images/vueJs.png" alt="Vue.js"></span>
            </p>
        </div>
    </div>
</div>

@endsection
