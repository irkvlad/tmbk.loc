{{--list<br>@dump($list)  --}}       {{-- Полный список полученных отчетов --}}
{{--draver<br>@dump($dravers)   --}}    {{--Отчеты сгрупированные по водителям--}}
{{--report_id<br>@dump($report_id)--}}    {{-- id - текущиего отчета    --}}
{{--reports<br>@dump($reports)--}}      {{--Треки текущего отчета сортированные по скоростям --}}
<hr>
<h3>{{$sheet[0]['header']}}, группа {{$sheet[0]['title']}}</h3>
@php  $columns=$header=$data = null; @endphp
@php $track_id = $sheet[0]['header_id']; //Метка для класов для форматирования @endphp

<style> /*Споллер таблицы*/
    .label tr td label {display: block; }
    [data-toggle="toggle"] { display: none; }

    tr.group,
    tr.group:hover {
        background-color: #ddd !important;
    }
    .ahrev {cursor: pointer;text-decoration:underline;font-weight: 600;}
</style>
<div class="row">
                <table class="myTable table table-bordered table-hover table-sm table-responsive-sm">
                    <thead class="thead-light ">
                        <tr>

                                <th scope="col">Время начала</th>
                                <th scope="col">Продолжительность</th>
                                <th scope="col">Средняя скорость, км/ч</th>
                                <th scope="col">Макс. скорость, км/ч</th>
                                <th scope="col">Адрес</th>

                        </tr>
                    </thead>

                    @php
                        $sheetGroupDate = $sheet->sortBy('data_header')->groupBy('data_header');
                    @endphp

                @foreach($sheetGroupDate as $date)
                    @php $sort_speed_day = $date->sortByDesc('max_speed');  @endphp
                    @php $max_speed_day = $sort_speed_day->first()  @endphp
                    <tbody class="label">
                        <tr>
                            @php
                                if($max_speed_day['max_speed'] > $spid[2])     $style = 'list-group-item-danger';
                                elseif($max_speed_day['max_speed'] > $spid[1]) $style = 'list-group-item-warning';
                                elseif($max_speed_day['max_speed'] > $spid[0]) $style = 'list-group-item-success';
                                else $style = '';
                            @endphp
                            <td colspan="5" class="{{$style}}">
                                <label for="header{{$track_id}}{{$loop->index}}">
                                   <b>Максимальная скорость [ {{$max_speed_day['data_header']}} ]</b>
                                   <i> {{$max_speed_day['start_time']}} -
                                    {{$max_speed_day['duration']}} -
                                    {{$max_speed_day['max_speed']}}км/ч</i>
                                </label>
                                <input type="checkbox" name="header{{$track_id}}{{$loop->index}}" id="header{{$track_id}}{{$loop->index}}" data-toggle="toggle">
                            </td>
                        </tr>
                        </tbody>
                        <tbody class="hide" style="display: none">

                        @foreach($sort_speed_day as $row )
                            <tr>
                                <td>{{$row['start_time']}}</td>
                                <td>{{$row['duration']}}</td>
                                <td>{{$row['avg_speed']}}</td>
                                <td>{{$row['max_speed']}}</td>
                                <td><a target='_blank' href="https://www.google.com/maps/search/?api=1&query=<?php echo $row['max_speed_lat'].','.$row['max_speed_lng'].'&z=10'?>">
                                        {{$row['max_speed_address']}}; lat{{$row['max_speed_lat']}},lng{{$row['max_speed_lng']}} </a></td>
                            </tr>
                        @endforeach

                        </tbody>
                    @endforeach
                </table>
</div>

<script type="text/javascript">

    $('td.ahrev').on('click', function() {
        var vtext=$(this).text();
        $('a:contains('+vtext+')').click();
    });

    $(document).ready( function () {
        $('.myTable').DataTable();
    } );

</script>
