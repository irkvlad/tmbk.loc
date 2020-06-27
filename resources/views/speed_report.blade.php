<!doctype html>
<html lang="ru">
<head>
    @include('speed_report.header')
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-12 text-center" >
            <div class="logo-tmbk">
                <a href="/" title="На главную">
                    <img  src={{asset('img/logo-tmbk.png')}} alt="">
                </a>
                <br>
           <hr>
            <h4>@yield('title')</h4>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-lg-2 col-md-3 col-sm-12 ">
            @include('speed_report.nav')
            @yield('submenu')
        </div>

        <div class="col-lg-10 col-md-9 col-sm-12 ">
            @yield('content')
        </div>
    </div>
    <div class="row ">
        @include('speed_report.footer')
    </div>
</div>
</body>
</html>
