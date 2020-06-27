{{--@dd($list)--}}
{{--@dd($report_id)--}}
{{--@dd($report)--}}
{{--@dd($trRows)--}}


@php
    $from=$to=''; //период
    $spid110=$spid120=$spid130=$spid=0; //количество случаев по скоростям

@endphp

@extends('over_speed') {{--//Основной шаблон--}}

@section('submenu')
    @isset($list)
        <nav class="navbar navbar-light bg-light navbar-expand-md ">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggler" aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarToggler">
                <ul class="navbar-nav mr-auto mt-2 mt-lg-0 flex-column">
                    @foreach($list as $li)
                        @if ($report_id == $li['id'])
                            @section('title',$li['title']) {{--в шаблоне--}}
                        @endif
                        @php /*Сохраняю период отчета*/
                            if ( $report_id == $li['id']  ) {
                                $class='active'; //Активное меню
                                $from=date('d-m-Y H:i:s', strtotime($li['from']));
                                $to=date('d-m-Y H:i:s', strtotime($li['to']));
                            }
                            else {
                                $class='';
                             }
                        @endphp
                        {{--Список отчеов в навигацию --}}
                        <li class='nav-item {!!  $class  !!}'>
                            <a class="nav-link" href="{{ action('OverSpeedController@index', [ 'id' => $li['id'] ]) }}">
                                {!!   $report_id == $li['id'] ? '<span class="sr-only">(current)</span>' : null !!}
                                {{$li['title']}}
                                <span style="white-space: nowrap">{{date('d-m-Y', strtotime($li['from']))}}</span>
                                <span style="white-space: nowrap">{{date('d-m-Y', strtotime($li['to']))}}</span>
                            </a>
                        </li>
                    @endforeach
                    {{--<li class="nav-item">
                         <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a> class="{{ request()->is('podcasts/*') ? 'active' : null }}"
                     </li> --}}
                </ul>
            </div>
        </nav>
    @endisset
@endsection

@section('content')
    <div class="w-100 p-3" id="piechart" ></div>
    <div>с {{$from}} по {{$to}}</div>

    @isset($report)
        <div class="tab-content" id="nav-tabContent bg-info">
            <div class="tab-pane fade show active" id="list-all" role="tabpanel" aria-labelledby="list-all-list">
               @include('over_speed.consolidated_reportreport')
{{--               @include('over_speed.tast')--}}
            </div>
              @foreach($report['sheets'] as $sheet )
                  <div class="tab-pane fade " id="list-{{$loop->index}}" role="tabpanel" aria-labelledby="list-{{$loop->index}}-list">
                      @include('over_speed.all_treack_table',['sheet'=>$sheet])
                  </div>
{{--                  @dd($sheet)--}}
              @endforeach
        </div>
        <hr>
        <div class="list-group list-group-horizontal scrollmenu" id="list-tab" role="tablist">
            <a class="list-group-item list-group-item-action active" id="list-all-list" data-toggle="list" href="#list-all" role="tab" aria-controls="controls-all">
                Сводный</a>
            @foreach($report['sheets'] as $sheet )
                <a class="list-group-item list-group-item-action " id="list-{{$loop->index}}-list" data-toggle="list" href="#list-{{$loop->index}}" role="tab" aria-controls="controls-{{$loop->index}}">
                    {{$sheet['header']}}</a>
            @endforeach
        </div>
    @endisset
    <hr>
{{--    @dd($list_hrev)--}}
   {{-- <div class="card" style="width: 18rem;">
        <div class="card-header">
            <h5 class="card-title">Итого</h5>
        </div>
        <div class="card-body d-flex" >
            <div class="p-2 flex-fill">Поездок </div>
            <div class="p-2 flex-fill">372</div>
            <hr>
        </div>
        <div class="card-body">
            <hr>
            <a href="#" class="card-link">"Где мои"</a>
        </div>
    </div>--}}
 {{--   <br>   list-group-horizontal-sm bg-dark overflow-hidden d-flex flex-nowrap
    <br>
    <br>


    <!-- Tab panes -->
    <div class="tab-content">
        <div class="tab-pane   active" id="home1" role="tabpanel">
            Velit aute mollit ipsum ad dolor consectetur nulla officia culpa adipisicing exercitation fugiat tempor. Voluptate deserunt sit sunt nisi aliqua fugiat proident ea ut. Mollit voluptate reprehenderit occaecat nisi ad non minim tempor sunt voluptate consectetur exercitation id ut nulla. Ea et fugiat aliquip nostrud sunt incididunt consectetur culpa aliquip eiusmod dolor. Anim ad Lorem aliqua in cupidatat nisi enim eu nostrud do aliquip veniam minim.
        </div>
        <div class="tab-pane  " id="profile1" role="tabpanel">
            Cupidatat quis ad sint excepteur laborum in esse qui. Et excepteur consectetur ex nisi eu do cillum ad laborum. Mollit et eu officia dolore sunt Lorem culpa qui commodo velit ex amet id ex. Officia anim incididunt laboris deserunt anim aute dolor incididunt veniam aute dolore do exercitation. Dolor nisi culpa ex ad irure in elit eu dolore. Ad laboris ipsum reprehenderit irure non commodo enim culpa commodo veniam incididunt veniam ad.
        </div>
        <div class="tab-pane  " id="messages1" role="tabpanel">
            Ut ut do pariatur aliquip aliqua aliquip exercitation do nostrud commodo reprehenderit aute ipsum voluptate. Irure Lorem et laboris nostrud amet cupidatat cupidatat anim do ut velit mollit consequat enim tempor. Consectetur est minim nostrud nostrud consectetur irure labore voluptate irure. Ipsum id Lorem sit sint voluptate est pariatur eu ad cupidatat et deserunt culpa sit eiusmod deserunt. Consectetur et fugiat anim do eiusmod aliquip nulla laborum elit adipisicing pariatur cillum.
        </div>
        <div class="tab-pane  " id="settings1" role="tabpanel">
            Irure enim occaecat labore sit qui aliquip reprehenderit amet velit. Deserunt ullamco ex elit nostrud ut dolore nisi officia magna sit occaecat laboris sunt dolor. Nisi eu minim cillum occaecat aute est cupidatat aliqua labore aute occaecat ea aliquip sunt amet. Aute mollit dolor ut exercitation irure commodo non amet consectetur quis amet culpa. Quis ullamco nisi amet qui aute irure eu. Magna labore dolor quis ex labore id nostrud deserunt dolor eiusmod eu pariatur culpa mollit in irure.
        </div>
    </div>

    <!-- List group -->
    <div class="list-group list-group-horizontal-sm" id="myList" role="tablist">
        <a class="list-group-item list-group-item-action active" data-toggle="list" href="#home1" role="tab">Home1</a>
        <a class="list-group-item list-group-item-action" data-toggle="list" href="#profile1" role="tab">Profile1</a>
        <a class="list-group-item list-group-item-action" data-toggle="list" href="#messages1" role="tab">Messages1</a>
        <a class="list-group-item list-group-item-action" data-toggle="list" href="#settings1" role="tab">Settings1</a>
    </div>--}}
@endsection
{{--@dd($report)--}}
