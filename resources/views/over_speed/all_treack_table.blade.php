<hr>
@php $_group = getGroupLabel_by_tracer_id($sheet['header'])@endphp
<h3>{{$sheet['header']}}, группа {{$_group['title']}}</h3>
@php
    $columns=$header=$data = null;

@endphp
{{--@dd($columns)--}}
{{--@dd($sheet)--}}
{{--@dd($trRows)--}}

<?php
$track_id = $sheet['entity_ids'][0]; //Метка для класов для форматирования

foreach ($sheet['sections'] as $section ){
    if ($section['type'] == 'table'){
        $data = $section['data'];
        $columns = $section['columns'];//Зоголовки столбцов
        $header = $section['header']; //Заголовок таблицы с условие отбора в отчете
    }
}
?>

<style> /*Споллер таблицы*/
    .label tr td label {display: block; }
    [data-toggle="toggle"] { display: none; }
</style>

<div class="alert alert-dark" role="alert">
{{$header}}

</div>
<div class="row">

                <table class="table table-bordered table-hover table-sm table-responsive-sm">
                    <thead class="thead-light ">
                        <tr>
                            @for($i=0;$i< count($columns);$i++)
                                <th scope="col">{{$columns[$i]['title']}}</th>
                            @endfor
                        </tr>
                    </thead>

                    @foreach($data as $label)
                        @php sort_row_traks($label['rows']); @endphp

                        <tbody class="label">
                        <tr>
                            @php
                                if($label['rows'][0]['max_speed']['raw'] > 130)     $style = 'list-group-item-danger';
                                elseif($label['rows'][0]['max_speed']['raw'] > 120) $style = 'list-group-item-warning';
                                elseif($label['rows'][0]['max_speed']['raw'] > 110) $style = 'list-group-item-success';
                                else $style = '';
                                @endphp
                            <td colspan="5" class="{{$style}}">
                                <label for="header{{$track_id}}{{$loop->index}}">
                                   <b>[ {{$label['header']}} ]</b>
                                   <i> {{$label['rows'][0]['start_time']['v']}} -
                                    {{$label['rows'][0]['duration']['v']}} -
                                    {{$label['rows'][0]['max_speed']['v']}}км/ч</i>
                                </label>
                                <input type="checkbox" name="header{{$track_id}}{{$loop->index}}" id="header{{$track_id}}{{$loop->index}}" data-toggle="toggle">

                            </td>
                        </tr>
                        </tbody>
                        <tbody class="hide" style="display: none">

                        @foreach($label['rows'] as $row )
                            <tr>
                                <td>{{$row['start_time']['v']}}</td>
                                <td>{{$row['duration']['v']}}</td>
                                <td>{{$row['avg_speed']['v']}}</td>
                                <td>{{$row['max_speed']['v']}}</td>
                                <td><a href="https://www.google.com/maps/<?php echo '@'.$row['max_speed_address']['location']['lat'].','.$row['max_speed_address']['location']['lng'].',10z'?>">
                                        {{$row['max_speed_address']['v']}} </a></td>
                            </tr>
                        @endforeach
                        </tbody>
                    @endforeach
                </table>
</div>

