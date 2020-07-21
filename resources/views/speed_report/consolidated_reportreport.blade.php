{{--$list @dump($list)         --}}{{-- Полный список полученных отчетов --}}
{{--$draver @dump($dravers)       --}}{{--Отчеты сгрупированные по водителям--}}
{{--$report_id @dump($report_id)    --}}{{-- id - текущиего отчета    --}}
{{--$reports @dump($reports)      --}}{{--Треки текущего отчета сортированные по скоростям --}}

<div class="alert " role="alert">
    <h3>Сводный отчет</h3>
</div>
<style>
    tr.group,
    tr.group:hover {
        background-color: #ddd !important;
    }
    .ahrev {cursor: pointer;text-decoration:underline;font-weight: 600;}
</style>
<div class="row">
    <div id="accordion">
        @php //$reports=getArrayTrack($report);@endphp
        @php $FLAG3=true; @endphp
        @php $FLAG2=true; @endphp
        @php $FLAG1=true; @endphp
        @foreach($reports as $row)
            @if($row['max_speed'] > 130 and $FLAG3 )
                @php $FLAG3=false;$style = 'list-group-item-danger';@endphp
                <div class="card">
                    <div class="card-header" id="headingOne">
                        <h5 class="mb-0">
                            <button id='speed3' class="btn btn-link {{$style}}" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                <b>[Скорости выше 130 км/ч]</b>
                                <i> {{$row['max_speed']}}км/ч -
                                    {{$row['title']}} -
                                    {{$row['header']}}км/ч</i>
                            </button>
                        </h5>
                    </div>
                    <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                        <div class="card-body">
                            <table id="myTable3" class=" myTable table table-striped table-bordered" style="width:100%"> {{--class="table table-bordered table-hover table-sm table-responsive-sm">--}}
                                <thead class="thead-light ">
                                    <tr>
                                        <th scope="col"> № </th>
                                        <th scope="col"> Дата </th>
                                        <th scope="col"> Длительность </th>
                                        <th scope="col"> Макс. скорость </th>
                                        <th scope="col"> Филиал </th>
                                        <th scope="col" >Г.Н. </th>
                                    </tr>
                                </thead>
                                <tbody>

            @elseif($row['max_speed'] <= 130 and $row['max_speed'] > 120 and $FLAG2 )
                @if(!$FLAG3)
                                </tbody>
                            </table>
                        </div><!--card-body-->
                    </div><!--collapseOne-->
                </div><!--card-->
                @endif
                @php $FLAG2=false; $style = 'list-group-item-warning';@endphp
                <div class="card">
                    <div class="card-header" id="headingTwo">
                        <h5 class="mb-0">
                            <button  id='speed2'  class="btn btn-link collapsed {{$style}}" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                <b>[Скорости выше 120 км/ч]</b>
                                <i> {{$row['max_speed']}}км/ч -
                                    {{$row['title']}} -
                                    {{$row['header']}}км/ч</i>
                            </button>
                        </h5>
                    </div>
                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                        <div class="card-body">
                            <table id="myTable2" class="myTable table table-striped table-bordered" style="width:100%"> {{--class="table table-bordered table-hover table-sm table-responsive-sm">--}}
                                <thead class="thead-light ">
                                    <tr>
                                        <th scope="col"> № </th>
                                        <th scope="col"> Дата </th>
                                        <th scope="col"> Длительность </th>
                                        <th scope="col"> Макс. скорость </th>
                                        <th scope="col"> Филиал </th>
                                        <th scope="col">Г.Н. </th>
                                    </tr>
                                </thead>
                            <tbody>


            @elseif($row['max_speed'] <= 120 and $row['max_speed'] > 110  and $FLAG1 )
                @if(!$FLAG3 OR !$FLAG2)
                                </tbody>
                            </table>
                        </div><!--card-body-->
                    </div><!--collapseOne-->
                </div><!--card-->
                @endif
                @php $FLAG1=false; $style = 'list-group-item-success'; @endphp
                <div class="card">
                    <div class="card-header" id="headingThree">
                        <h5 class="mb-0">
                            <button  id='speed1' class="btn btn-link collapsed {{$style}}" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                 <b>[Скорости выше 110 км/ч]</b>
                                <i> {{$row['max_speed']}}км/ч -
                                    {{$row['title']}} -
                                    {{$row['header']}}км/ч</i>
                            </button>
                        </h5>
                    </div>
                    <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                        <div class="card-body">
                            <table id="myTable1" class="myTable table table-striped table-bordered" style="width:100%">
                                <thead class="thead-light ">
                                <tr>
                                    <th scope="col"> № </th>
                                    <th scope="col"> Дата </th>
                                    <th scope="col"> Длительность </th>
                                    <th scope="col"> Макс. скорость </th>
                                    <th scope="col"> Филиал </th>
                                    <th scope="col">Г.Н. </th>
                                </tr>
                                </thead>
                                <tbody>
            @endif
                                       <tr>
                                           <td>{{$loop->index}}</td>
                                            <td>{{$row['data_header']}} </td>
                                            <td> {{$row['duration']}}</td>
                                            <td>{{$row['max_speed']}}км/ч</td>
                                            <td>{{$row['title']}}</td>
                                            <td class="ahrev" >{{$row['header']}}</td>
                                       </tr>

         @php
              if ($row['max_speed'] >= 130)     $spid130++;
              elseif ($row['max_speed'] >= 120) $spid120++;
              elseif ($row['max_speed'] >= 110) $spid110++;
         @endphp
         @endforeach <!--$row-->
                                </tbody>
                            </table>
                        </div><!--card-body-->
                    </div><!--collapseOne-->
                </div><!--card-->
    <script type="text/javascript">

        $('td.ahrev').on('click', function() {
            var vtext=$(this).text();
            $('a:contains('+vtext+')').click();
        });

        $(document).ready( function () {
            $('.myTable').DataTable();
        } );
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);
        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['Task', 'Максимальная скорость'],
                ['Скорость\u00A0>110\u00A0({{$spid110}})', {{$spid110}}],
                ['Скорость\u00A0>120\u00A0({{$spid120}})', {{$spid120}}],
                ['Скорость\u00A0>130\u00A0({{$spid130}})', {{$spid130}}]
            ]);
            var options = {
                title: 'Максимальная скорость',
                //pieHole: 0.6,
                slices: {
                    0: { color: '#28a745' },
                    1: { color: '#ffc107' },
                    2: { color: '#dc3545' }
                },

                chartArea:{top:20,bottom:20, width:'100%',height:'100%'}
            };
            var chart = new google.visualization.PieChart(document.getElementById('piechart'));
            google.visualization.events.addListener(chart, 'select',  function selectHandler() {
                var selectedItem; //= chart.getSelection()[0];     alert(selectedItem.row)   ;
                var value ;//= data.getValue(selectedItem.row, 0);

                if(chart.getSelection()[0]) {
                    selectedItem = chart.getSelection()[0];
                    value = data.getValue(selectedItem.row, 0);
                }else {
                    $('#list-all-list').click();
                    $(setg).click();
                    $("html,body").scrollTop($(setg).offset().top);
                    return;
                }

                $('#list-all-list').click();

                if(value=='Скорость\u00A0>130\u00A0({{$spid130}})') {$('#speed3').click();setg='#speed3'}
                if(value=='Скорость\u00A0>120\u00A0({{$spid120}})') {$('#speed2').click();setg='#speed2'}
                if(value=='Скорость\u00A0>110\u00A0({{$spid110}})') {$('#speed1').click();setg='#speed1'}
                  /*alert('The user selected ' + value);*/
                $("html,body").scrollTop($(setg).offset().top);

            });
            chart.draw(data, options);
        }

        $('#speed3').append('; {{$spid130}} нарушений.')
        $('#speed2').append('; {{$spid120}} нарушений.')
        $('#speed1').append('; {{$spid110}} нарушений.')

        function selectHandler() {
            var selectedItem = chart.getSelection()[0];
            var value = data.getValue(selectedItem.row, 0);
            alert('The user selected ' + value);
        }
    </script>

    </div><!--accordion-->
</div><!--row-->

