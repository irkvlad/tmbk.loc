<div id='header-logo' class="container">
<div class="pt-5">
    <div class="logo-tmbk">
        <a href="/" title="На главную">
            <img  src="public/img/logo-tmbk-v.png" alt="">
            <img class="d-lg-none" src="public/img/logo-tmbk.png" alt="">
        </a>
    </div>

<a class="navbar-brand btn btn-secondary " href="#" onclick="document.getElementById('logout-form').submit();" > Выход </a>
{{--<a class="btn btn-secondary" href="#" role="button"> Отчет по заправкам </a>--}}
</div>
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>

<hr>

</div>


