<div class="pt-5 menu-btn">
    <a class="navbar-brand btn btn-secondary" href="#" onclick="document.getElementById('gas_report').submit();" >Заправки</a>
    <a class="navbar-brand btn btn-secondary" href="#" onclick="document.getElementById('logout-form').submit();" >Выход</a>
</div>
<form id="gas_report" action="{{ route('gas_report') }}" method="get" style="display: none;">
    @csrf
</form>
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>
<hr>



