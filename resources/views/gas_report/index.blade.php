
{{--//Основной шаблон--}}
@extends('gas_report')

{{--// Левое меню--}}
@section('submenu')
        <nav class="navbar navbar-light bg-light navbar-expand-md ">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggler" aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarToggler">
                <?php // TODO Выбор периода ?>

                <ul class="navbar-nav mr-auto mt-2 mt-lg-0 flex-column">
                    <li class='nav-item @if($gas == "Отчет за день") active @endif'>
                        <form id="data" action="#{{--{{ route('gas_report') }}--}}" method="post" >
                            @csrf
                            <label for="localdate">Выбрать период: </label>
                            <input name="date" type="text" data-range="true" data-multiple-dates-separator=" - " class="datepicker-here" style="width: 100%"/>
                        </form>
                    </li>
                    <li class='nav-item @if($gas == "Отчет за день") active @endif'>
                        <a class="nav-link" href="{{ action('GasController@show_reports', [ 'gas' => 'last_day' ]) }}">
                           Отчет за день
                        </a>
                    </li>
                    <li class='nav-item @if($gas == "Отчет за неделю") active @endif'>
                        <a class="nav-link" href="{{ action('GasController@show_reports', [ 'gas' => 'last_week' ]) }}">
                           Отчет за неделю
                        </a>
                    </li>
                    <li class='nav-item @if($gas == "Отчет за месяц") active @endif'>
                        <a class="nav-link" href="{{ action('GasController@show_reports', [ 'gas' => 'last_month' ]) }}">
                           Отчет за месяц
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
        @isset($list)
    @endisset
@endsection

@section('content')
    @if($gas == "Отчет за день")
        <div>{{$gas}}<br>Дата: {{ date('d.m.Y',strtotime($startDay)) }}</div>
    @else
        <div>{{$gas}}<br>Период: {{ date('d.m.Y',strtotime($startDay)) }} - {{ date('d.m.Y',strtotime($endDay)) }}</div>
    @endif

    @isset($message)
        @if ($message)
            <div  class="alert alert-warning" role="alert">{{ $message }}</div>
        @endif
    @endisset

@isset($gas_on_cards)
    <div class="row">
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="list-consolidated" role="tabpanel" aria-labelledby="list-consolidated-list">
                @include('gas_report.consolidated_report')
            </div>

            @foreach($gas_on_cards as $card )
                <div class="tab-pane fade " id="list-{{$loop->index}}" role="tabpanel" aria-labelledby="list-{{$loop->index}}-list">
                       @include('gas_report.card_table',['card'=>$card,'index'=>"$loop->index"])
                </div>
            @endforeach
        </div>
    </div>
<hr>
<div class="row">
    <div class="list-group list-group-horizontal scrollmenu" id="list-tab" role="tablist">
        <a class="list-group-item list-group-item-action active" id="list-consolidated-list" href="#list-consolidated" role="tab" aria-controls="consolidated">Сводный</a>

        @foreach($gas_on_cards as $card )
            @php
                $card_owner = explode(' ', $card[0]->card_owner);
                $name_tab =  $card_owner[0] .' '. mb_substr($card_owner[1], 0,1).'.';
            @endphp
            <a class="list-group-item list-group-item-action" id="list-{{$loop->index}}-list" href="#list-{{$loop->index}}" role="tab" aria-controls="controls-{{$loop->index}}">
                {{$name_tab}}</a>
        @endforeach
    </div>
</div>




       {{-- <div class="tab-content" id="nav-tabContent bg-info">
            <div class="tab-pane fade show active" id="list-all" role="tabpanel" aria-labelledby="list-all-list">
                @include('gas_report.consolidated_report')
            </div>
            @foreach($gas_on_cards as $card )
                <div class="tab-pane fade " id="list-{{$loop->index}}" role="tabpanel" aria-labelledby="list-{{$loop->index}}-list">
                    @include('gas_report.card_table',['card'=>$card,'tabindex'=>"list-$loop->index"])
                </div>
                      @dump($card)
            @endforeach
        </div>
        <hr>

        <div class="list-group list-group-horizontal scrollmenu" id="list-tab" role="tablist">
            <a class="list-group-item list-group-item-action active" id="list-all-list" data-toggle="list" href="#list-all" role="tab" aria-controls="controls-all">
                Сводный</a>

            @foreach($gas_on_cards as $card )
                @php
                    $card_owner = explode(' ', $card[0]->card_owner);
                    $name_tab =  $card_owner[0] .' '. mb_substr($card_owner[1], 0,1).'.';
                @endphp
                <a class="list-group-item list-group-item-action " id="list-{{$loop->index}}-list" data-toggle="list" href="#list-{{$loop->index}}" role="tab" aria-controls="controls-{{$loop->index}}">
                    {{$name_tab}}</a>
            @endforeach
        </div>--}}

    <hr>
@endisset
<script type="text/javascript">
    $('#list-tab a').on('click', function (e) {
        e.preventDefault()
        $(this).tab('show')
    })

    $('#list-tab a').on('shown.bs.tab', function (e) {
        e.target // newly activated tab
        e.relatedTarget // previous active tab
        $.fn.dataTable.tables( {visible: true, api: true} ).columns.adjust();
    })

    var i = 0;
    $('.datepicker-here').datepicker({
        onSelect: function onSelect(fd, date) {
            if( i == 1)  document.getElementById('data').submit();
            i++;
        }
    })
</script>

@endsection

