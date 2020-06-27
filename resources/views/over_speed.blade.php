<!doctype html>
<html lang="ru">
<head>
    @include('over_speed.header')

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
                <div class="card-header">Данный отчет генерируется напрямую с сервиса "Где Мои" (требует больше времени)
                    @if (Session::has('status'))
                        <div  class="alert alert-success" role="alert">{{Session::get('status')}}</div>
                    @endif
                </div>
            <hr>
            <h4>@yield('title')</h4>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">

        <div class="col-lg-2 col-md-3 col-sm-12 ">
            @include('over_speed.nav')
            @yield('submenu')
        </div>

        <div class="col-lg-10 col-md-9 col-sm-12 ">
            @yield('content')
        </div>

    </div>

    <div class="row ">
        @include('over_speed.footer')
    </div>
</div>
</body>
</html>
