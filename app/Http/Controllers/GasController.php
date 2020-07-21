<?php
/************
 * Проба чтения Excel
 ***********/

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Thybag\SharePointAPI;
use RuntimeException;
use Throwable;
use App\GasStation;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Auth\User;

class GasController extends Controller
{
    public  function __construct()
    {
        $this->middleware('auth');
    }/**/
    public function show_reports(Request $request)
    {
        $gas = $request->get('gas');
        $d = $request->get('date',null);
        $date = null;
        if($d <> null) $date = explode(' - ', $d);
        $message = '';

        //Отчет за период
        if ( $date <> null) {
            $startDay = date("Y-m-d", strtotime($date[0]));
            $endDay = date("Y-m-d", strtotime($date[1]));
            $gas_on_last = GasStation::where('date', '>=', $startDay)->where('date', '<=', $endDay)->orderBy('card_owner')->get();
            $gas_on_cards = GasStation::where('date', '>=', $startDay)->where('date', '<=', $endDay)->orderBy('date')->orderBy('time')->get()->groupBy('card_number');
            $gas = 'Отчет за период';
            if(count($gas_on_last)==0) {
                $message    = 'За данный период данных нет. Загрузите отчет.';
            }
        }

        // Отчет за день
        elseif ( $gas =='last_day' ) {
            $on_day         = GasStation::orderBy('date', 'desc')->value('date');
            $gas_on_last    = GasStation::where('date', $on_day)->orderBy('card_owner')->get();
            $gas_on_cards   = GasStation::where('date', $on_day)->orderBy('date')->orderBy('time')->get()->groupBy('card_number');

            $gas            = 'Отчет за день';
            $startDay       = $on_day;//GasStation::first()->date;
            $endDay         = '';

            if(count($gas_on_last) == 0) {
                $message    = 'За прошлый день данных нет.Загрузите отчет.';
                $startDay   = $on_day;//GasStation::first()->date;
                $endDay     = '';
            }
        }

        // Отчет за месяц
        elseif ( $gas == 'last_month' ) {
            $startDay       = date("Y-m-01", strtotime("-1 month"));
            $endDay         = date("Y-m-t", strtotime("-1 month"));
            $gas_on_last    = GasStation::where('date', '>=', $startDay)->where('date', '<=', $endDay)->orderBy('card_owner')->get();
            $gas_on_cards   = GasStation::where('date', '>=', $startDay)->where('date', '<=', $endDay)->orderBy('date')->orderBy('time')->get()->groupBy('card_number');
            $gas            = 'Отчет за месяц';
            if(count($gas_on_last)==0) {
                $message    = 'За прошлый месяц данных нет. Загрузите отчет.';
            }
        }

        // Отчет за неделю
        else  {
            $startDay       = date("Y-m-d", strtotime('monday last week'));
            $endDay         = date("Y-m-d", strtotime('monday this week'));
            $gas_on_last    = GasStation::where('date', '>=', $startDay)->where('date', '<', $endDay)->orderBy('card_owner')->get();
            $gas_on_cards   = GasStation::where('date', '>=', $startDay)->where('date', '<', $endDay)->orderBy('date')->orderBy('time')->get()->groupBy('card_number');
            $gas            = 'Отчет за неделю';
            if(count($gas_on_last)==0) {
                $message   = 'За прошлую неделю данных нет. Загрузите отчет.';
            }
        }

        $viwParam = [
             'gas_on_last'  => $gas_on_last
            ,'startDay'     => $startDay
            ,'endDay'       => $endDay
            ,'gas'          => $gas
            ,'message'          => $message
            ,'gas_on_cards'          => $gas_on_cards
        ];

        return view('gas_report.index', $viwParam);
    }
}








