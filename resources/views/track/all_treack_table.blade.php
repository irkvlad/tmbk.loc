<hr>
<div>{{$header}}</div>
{{--@dd($columns)--}}
{{--@dd($rows)--}}
{{--@dd($trRows)--}}
{{--<div class="container">
<div class="d-flex row " >
    <div class="flex-grow-1 w-50 overflow-hidden justify-content-start col" > Трек </div>
    @for($i=1;$i< count($sections[0]['columns']);$i++)
        <div class="col overflow-hidden justify-content-end" >{{$sections[0]['columns'][$i]['title']}}</div>
    @endfor
</div>
<div class="d-flex row" >
    <div class="flex-grow-1 overflow-hidden justify-content-start col" >1111111111111111111111111111111111111111</div>
    <div class="col overflow-hidden justify-content-end" >222</div>
    <div class="col overflow-hidden justify-content-end" >333</div>
    <div class="col overflow-hidden justify-content-end" >444</div>
    <div class="col overflow-hidden justify-content-end" >555</div>
    <div class="col overflow-hidden justify-content-end" >666</div>
</div>
</div>--}}
<table class="table table-bordered table-hover table-sm table-responsive-sm">
    <thead class="thead-light ">
    <tr>
    @for($i=0;$i< count($columns);$i++)
        <th scope="col">{{$columns[$i]['title']}}</th>
    @endfor
    </tr>
    </thead>
    <tbody>

   {{-- <?php
        if('Всего за период' <> $header){
            $trRows = $rows;
        echo ('Всего за период' <> $header? 'true':'false') . 'Всего за период != $header';}
    ?>--}}

   @if('Всего за период' == $header)
     rows = <br> {{-- {{var_dump($rows)}}--}}
    @foreach($rows as $row)
        <tr>
            <td scope="row">{{$row['object']['v']}}</td>
            <td>{{$row['count']['v']}}</td>
            <td>{{$row['length']['v']}}</td>
            <td>{{$row['time']['v']}}</td>
            <td>{{$row['avg_speed']['v']}}</td>
            <td>{{$row['max_speed']['v']}}</td>
        </tr>
    @endforeach
   @else
       @foreach($trRows as $row)
           data=<br>{{--{{var_dump($data)}}--}}
           <tr>
               <td scope="row">{{--{{$row['object']['v']}}--}}</td>
               <td>{{--{{$row['count']['v']}}--}}</td>
               <td>{{$row['length']['v']}}</td>
               <td>{{$row['time']['v']}}</td>
               <td>{{$row['avg_speed']['v']}}</td>
               <td>{{$row['max_speed']['v']}}</td>
           </tr>
       @endforeach
   @endif


    </tbody>
</table>



<hr>
    <div class="card" style="width: 18rem;">
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
    </div>
{{--@dd($row)--}}
