@php
    $from=$to='';
@endphp
@extends('track')
{{--@dd($reports)--}}
@section('submenu')
    @isset($reports)
{{--        @dd($reports)--}}
        <nav class="navbar navbar-light bg-light navbar-expand-md ">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggler" aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarToggler">
                <ul class="navbar-nav mr-auto mt-2 mt-lg-0 flex-column">
                        @foreach($reports as $report)
                            @php
                            if ( $report_id == $report['id']  ) {
                                $class='active';
                                $from=date('d-m-Y', strtotime($report['from']));
                                $to=date('d-m-Y', strtotime($report['to']));
                            }
                            else {
                                $class='';
                             }
                            @endphp
                            <li class='nav-item {!!  $class  !!}'>
                                <a class="nav-link" href="{{ action('TrackController@index', [ 'id' => $report['id'] ]) }}">
                                    {!!   $report_id == $report['id'] ? '<span class="sr-only">(current)</span>' : null !!}
                                    {{ date('d-m-Y', strtotime($report['created'])).' '.$report['title']  }}
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
    <div>с {{$from}} по {{$to}}</div>

  {{--  <div class="accordion" id="accordionExample">
        <div class="card">
            <div class="card-header" id="headingOne">
                <h5 class="mb-0">
                    <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        Разворачиваемая панель #1
                    </button>
                </h5>
            </div>

            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                <div class="card-body">
                    Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                    @include('track.all_treack_table')
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header" id="headingTwo">
                <h5 class="mb-0">
                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        Разворачиваемая панель #2
                    </button>
                </h5>
            </div>
            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                <div class="card-body">
                    Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header" id="headingThree">
                <h5 class="mb-0">
                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                        Разворачиваемая панель #3
                    </button>
                </h5>
            </div>
            <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                <div class="card-body">
                    Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                </div>
            </div>
        </div>
    </div>
--}}

  @isset($reportTrack)
{{--      @dd($reportTrack)--}}
  <div class="tab-content" id="nav-tabContent bg-info">
      @foreach($reportTrack['sheets'] as $sheet )
          <div class="tab-pane fade {{ $loop->index == 0 ? 'show active' : null  }}" id="list-{{$loop->index}}" role="tabpanel" aria-labelledby="list-{{$loop->index}}-list">
              @include('track.all_treack_table',['header'=>$sheet['header'],'columns'=>$sheet['sections'][0]['columns'],'rows'=>$sheet['sections'][0]['data'][0]['rows'],'data'=>$sheet['sections'][0]['data']])
          </div>
      @endforeach
  </div>
<hr>
  <div class="list-group list-group-horizontal scrollmenu" id="list-tab" role="tablist">
      @foreach($reportTrack['sheets'] as $sheet )
          <a class="list-group-item list-group-item-action {{ $loop->index == 0 ? 'active' : null  }}" id="list-{{$loop->index}}-list" data-toggle="list" href="#list-{{$loop->index}}" role="tab" aria-controls="controls-{{$loop->index}}">
              {{$sheet['header']}}</a>
      @endforeach
  </div>
  @endisset

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

