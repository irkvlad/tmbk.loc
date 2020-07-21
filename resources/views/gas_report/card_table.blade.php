{{--resources/views/gas_report/card_table.blade.php--}}

@php $style = 'list-group-item-light'; $total_qty = 0;$qty = 0; @endphp
<div class="alert " role="alert">
    <h3>Отчет по карте №{{$card[0]->card_number}}.</h3>
    <p>Держатель карты {{$card[0]->card_owner}}.</p>
    <p>Группа {{$card[0]->card_group}}.</p>
</div>


    <table id="myTable{{$index}}" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead class="thead-light ">
            <tr>
                <th scope="col"> №              </th>
                <th scope="col"> Дата           </th>
                <th scope="col"> Время          </th>
                <th scope="col"> Кол-во         </th>
                <th scope="col"> Цена на АЗС    </th>
                <th scope="col"> Услуга         </th>
                <th scope="col"> Операция       </th>
            </tr>
        </thead>
        <tbody>
{{--    По водителям                     --}}
        @foreach($card as $row)
            @php
                $date           =$row['date'];
                $time           =$row['time'];
                $qty            =$row['qty'];
                $amount         =$row['amount'];
                $service        =$row['service'];
                $operation      =$row['operation'];
                $total_qty      += $qty;
            @endphp

{{--    По заправкам водителя            --}}
            @foreach($row as $data)
                @php  $qty +=$data['qty'];   @endphp
            @endforeach <!--$data-->

            <tr>
                <td>{{$loop->index}}</td>
                <td>{{$date}}</td>
                <td>{{$time}}</td>
                <td>{{abs($qty)}}</td>
                <td>{{$amount}}</td>
                <td>{{$service}}</td>
                <td>{{$operation}}</td>
            </tr>
        @endforeach<!--$row-->
        </tbody>
        <tfoot>
            <tr>
                <th colspan="4">Итого, заправок: {{count($card)}}</th>
                <th colspan="3">Заправленно: {{abs($total_qty)}}</th>
            </tr>
        </tfoot>
    </table>


<script>
    $(document).ready(function() {
        $('#myTable{{$index}}').DataTable( {
            "language": {
                "url": "http://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Russian.json"
            }
        });
    } );
</script>
