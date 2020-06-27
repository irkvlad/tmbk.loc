<!doctype html>
<html lang="ru">
<head>
    @include('track.header')

</head>
<body>
<div class="container">

    <div class="row">
        <div class="col-12 text-center" >
            <h2>Отчет по поездкам</h2>
        </div>
    </div>


</div>
<div class="container">
    <div class="row">

        <div class="col-lg-2 col-md-3 col-sm-12 ">
            @include('track.nav')
            @yield('submenu')
        </div>

        <div class="col-lg-10 col-md-9 col-sm-12 ">
            @yield('content')
        </div>

    </div>

    <div class="row ">
        @include('track.footer')
    </div>



</div>
</body>
</html>
