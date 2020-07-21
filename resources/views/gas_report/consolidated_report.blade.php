{{--// resources/views/gas_report/consolidated_report.blade.php--}}

@php $style = 'list-group-item-light'; $total_qty = 0;$qty = 0; @endphp
<div class="alert " role="alert">
    <h3>Сводный отчет</h3>
</div>
<style>
    tr.group,tr.group:hover {background-color: #ddd !important;}
    .ahrev {cursor: pointer;}
</style>
{{--<div class="row">--}}
{{--    <table id="myTable" class="myTable table table-striped table-bordered" style="width:100%">--}}

    <table id="Consolidated" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead class="thead-light ">
            <tr>
                <th scope="col"> № </th>
                <th scope="col"> Кол-во </th>
                <th scope="col"> Цена на АЗС </th>
                <th scope="col"> Услуга </th>
                <th scope="col"> Номер карты </th>
                <th scope="col"> Группа карт </th>
                <th scope="col"> Держатель карты </th>
            </tr>
        </thead>
        <tbody>

{{--    По водителям                     --}}
@foreach($gas_on_cards as $row)
    @php
        $total_qty += $qty;
        $qty = 0;
        $amount =$row[0]['amount'];
        $service =$row[0]['service'];
        $card_group =$row[0]['card_group'];
        $card_number =$row[0]['card_number'];
        $card_owner =$row[0]['card_owner'];
        $card_owner_exp = explode(' ', $row[0]->card_owner);
        $name_tab =  $card_owner_exp[0] .' '. mb_substr($card_owner_exp[1], 0,1).'.';

    @endphp

{{--    По заправкам водителя            --}}
    @foreach($row as $data)
        @php  $qty +=$data['qty'];   @endphp
    @endforeach <!--$data-->
            <tr class="ahrev" hrev="{{$name_tab}}">
                <td>{{$loop->index}}</td>
                <td>{{$qty}}</td>
                <td>{{$amount}}</td>
                <td>{{$service}}</td>
                <td class="ahrev">{{$card_number}}</td>
                <td>{{$card_group}}</td>
                <td>{{$name_tab}}</td>
           </tr>

@endforeach<!--$row-->
        </tbody>
        <tfoot>
            <tr>
                <th colspan="4">Итого заправленно: </th>
                <th colspan="3">{{$total_qty}}</th>
            </tr>
        </tfoot>
    </table>


<script type="text/javascript">
    // Прокручиваем до Тогле объекта
   /* $(document).ready(function() {
        $('a.plus').click(function () {
            var vToggle=$(this).attr("toggle");
            var vGoTo = 0;
            var bottom = 0;
            $('.toggle').hide();
            $('#'+vToggle).slideToggle("slow");
            vGoTo = $('#'+vToggle).offset().top;
            bottom = vGoTo - $(window).height() + $('#'+vToggle).outerHeight();
            $("html,body").animate({scrollTop: bottom}, 100);

        });
    });
*/

    // Табличные функции
    $(document).ready(function() {
        $('#Consolidated').DataTable( {
            "language": {
                "url": "http://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Russian.json"
            }
        });
    } );

    // Перемещение к соответвствующей вкладке
    $('tr.ahrev').on('click', function() {
        var vtext=$(this).attr("hrev");
        $('a:contains('+vtext+')').click();
    });
</script>
