<div class="pt-5">
<a class="navbar-brand btn btn-secondary" href="#" onclick="document.getElementById('logout-form').submit();" > Выход </a>
{{--<a class="btn btn-secondary" href="#" role="button"> Отчет по заправкам </a>--}}
</div>
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>

<hr>



