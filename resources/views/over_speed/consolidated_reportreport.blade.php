
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
{{--        @dump($report['sheets'])--}}
    @php $reports=getArrayTrack($report);@endphp
{{--    "@dump($reports)--}}

        @php $FLAG3=true; @endphp
        @php $FLAG2=true; @endphp
        @php $FLAG1=true; @endphp
        @foreach($reports as $row)

            @if($row['max_speed'] > $spid[2] and $FLAG3 )
                @php $FLAG3=false;$style = 'list-group-item-danger';@endphp
                <div class="card">
                    <div class="card-header" id="headingOne">
                        <h5 class="mb-0">
                            <button id='speed3' class="btn btn-link {{$style}}" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                <b>[Скорости выше {{$spid[2]}} км/ч]</b>
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


            @elseif($row['max_speed'] <= $spid[2] and $row['max_speed'] > $spid[1] and $FLAG2 )
                @php $FLAG2=false; $style = 'list-group-item-warning';@endphp
                    </tbody>
            </table>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" id="headingTwo">
                        <h5 class="mb-0">
                            <button  id='speed2'  class="btn btn-link collapsed {{$style}}" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                <b>[Скорости выше {{$spid[1]}} км/ч]</b>
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


            @elseif($row['max_speed'] <= $spid[1] and $row['max_speed'] > $spid[0]  and $FLAG1 )
                @php $FLAG1=false; $style = 'list-group-item-success'; @endphp
                    </tbody>
                </table>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" id="headingThree">
                        <h5 class="mb-0">
                            <button  id='speed1' class="btn btn-link collapsed {{$style}}" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                 <b>[Скорости выше {{$spid[0]}} км/ч]</b>
                                <i> {{$row['max_speed']}}км/ч -
                                    {{$row['title']}} -
                                    {{$row['header']}}км/ч</i>
                            </button>
                        </h5>
                    </div>
                    <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                        <div class="card-body">
                    <table id="myTable1" class="myTable table table-striped table-bordered" style="width:100%"> {{--class="table table-bordered table-hover table-sm table-responsive-sm">--}}
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
                if ($row['max_speed'] >= $spid[2])     $spid130++;
                elseif ($row['max_speed'] >= $spid[1]) $spid120++;
                elseif ($row['max_speed'] >= $spid[0]) $spid110++;
            @endphp
         @endforeach <!--$row-->
            </tbody>
    </table>
                        </div>
                    </div>
                </div>
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
                ['Скорость > {{$spid[0]}}', {{$spid110}}],
                ['Скорость > {{$spid[1]}}', {{$spid120}}],
                ['Скорость > {{$spid[2]}}', {{$spid130}}]
            ]);
            var options = {
                title: 'Максимальная скорость',
                //pieHole: 0.6,
                slices: {
                    0: { color: '#28a745' },
                    1: { color: '#ffc107' },
                    2: { color: '#dc3545' }
                }
            };
            var chart = new google.visualization.PieChart(document.getElementById('piechart'));
            google.visualization.events.addListener(chart, 'select',  function selectHandler() {
                var selectedItem = chart.getSelection()[0];
                var value = data.getValue(selectedItem.row, 0);
                if(value=='Скорость > {{$spid[2]}}') {$('#speed3').click();$("html,body").scrollTop($('#speed3').offset().top);}
                 if(value=='Скорость > {{$spid[1]}}') {$('#speed2').click();$("html,body").scrollTop($('#speed2').offset().top);}
                 if(value=='Скорость > {{$spid[0]}}') {$('#speed1').click();$("html,body").scrollTop($('#speed1').offset().top);}
                  /*alert('The user selected ' + value);*/
            });
            chart.draw(data, options);
        }

        function selectHandler() {
            var selectedItem = chart.getSelection()[0];
            var value = data.getValue(selectedItem.row, 0);
            alert('The user selected ' + value);
        }
        /**/
       /*
        $(document).ready(function() {
            var groupColumn = 0;
            var table = $('#example').DataTable({
                "columnDefs": [
                    { "visible": false, "targets": groupColumn }
                ],
                "order": [[ groupColumn, 'asc' ]],
                "displayLength": 10,
                "drawCallback": function ( settings ) {
                    var api = this.api();
                    var rows = api.rows( {page:'current'} ).nodes();
                    var last=null;

                    api.column(groupColumn, {page:'current'} ).data().each( function ( group, i ) {
                        if ( last !== group ) {
                            $(rows).eq( i ).before(
                                '<tr class="group"><td colspan="5">'+group+'</td></tr>'
                            );

                            last = group;
                        }
                    } );
                }
            } );

            // Order by the grouping
            $('#example tbody').on( 'click', 'tr.group', function () {
                var currentOrder = table.order()[0];
                if ( currentOrder[0] === groupColumn && currentOrder[1] === 'asc' ) {
                    table.order( [ groupColumn, 'desc' ] ).draw();
                }
                else {
                    table.order( [ groupColumn, 'asc' ] ).draw();
                }
            } );
        } );*/
    </script>

    </div></div>

