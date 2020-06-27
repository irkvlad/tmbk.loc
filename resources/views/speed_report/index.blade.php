{{--@dump($list)--}}         {{-- Полный список полученных отчетов --}}
{{--@dd($dravers) --}}      {{--Отчеты сгрупированные по водителям--}}
{{--@dump($report_id)--}}    {{-- id - текущиего отчета    --}}
{{--@dump($reports)--}}      {{--Треки текущего отчета сортированные по скоростям --}}
@php
    $from=$to=''; //период
    $spid110=$spid120=$spid130=$spid=0; //количество случаев по скоростям
@endphp

@extends('speed_report') {{--//Основной шаблон--}}

@section('submenu')
    @isset($list)
        <nav class="navbar navbar-light bg-light navbar-expand-md ">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggler" aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarToggler">
                <ul class="navbar-nav mr-auto mt-2 mt-lg-0 flex-column">
                    @foreach($list as $li)
                        @if ($report_id == $li->number)
                            @section('title',$li->title) {{--в шаблоне--}}
                        @endif
                        @php /*Сохраняю период отчета*/
                            if ( $report_id == $li->number  ) {
                                $class='active'; //Активное меню
                                $from=date('d-m-Y H:i:s', strtotime($li->from));
                                $to=date('d-m-Y H:i:s', strtotime($li->to));
                            }
                            else {
                                $class='';
                             }
                        @endphp
                                             {{--Список отчеов в навигацию --}}
                        <li class='nav-item {!!  $class  !!}'>
                            <a class="nav-link" href="{{ action('OverSpeedController@speed_reports', [ 'id' => $li->number ]) }}">
                                {!!   $report_id == $li->number ? '<span class="sr-only">(current)</span>' : null !!}
                                {{$li->title}}
                                <span style="white-space: nowrap">{{date('d-m-Y', strtotime($li->from))}}</span>
                                <span style="white-space: nowrap">{{date('d-m-Y', strtotime($li->to))}}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </nav>
    @endisset
@endsection

@section('content')
{{--    <div class="w-100 p-3" id="piechart" ></div>--}}
    <div  id="piechart" ></div>
    <div>с {{$from}} по {{$to}}</div>

    @isset($dravers)
        <div class="tab-content" id="nav-tabContent bg-info">
            <div class="tab-pane fade show active" id="list-all" role="tabpanel" aria-labelledby="list-all-list">
               @include('speed_report.consolidated_reportreport')
            </div>
            @foreach($dravers as $draver )
            <div class="tab-pane fade " id="list-{{$loop->index}}" role="tabpanel" aria-labelledby="list-{{$loop->index}}-list">
                @include('speed_report.all_treack_table',['sheet'=>$draver])
            </div>
            @endforeach
        </div>
        <hr>
        <div class="list-group list-group-horizontal scrollmenu" id="list-tab" role="tablist">
            <a class="list-group-item list-group-item-action active" id="list-all-list" data-toggle="list" href="#list-all" role="tab" aria-controls="controls-all">
                Сводный</a>
            @foreach($dravers as $draver )
            <a class="list-group-item list-group-item-action " id="list-{{$loop->index}}-list" data-toggle="list" href="#list-{{$loop->index}}" role="tab" aria-controls="controls-{{$loop->index}}">
                {{$draver[0]->header}}</a>
            @endforeach
        </div>
    @endisset
    <hr>
@endsection

