<?php

namespace App\Http\Controllers;

error_reporting(E_ALL);
ini_set('display_errors', 'On');

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7;
use Illuminate\Http\Request;
use App\Http\Requests;
use PhpParser\Node\Stmt\Foreach_;
use PHPUnit\Util\Json;
use Config;
use App\Http\Helpers\TrackHelper;
use Illuminate\Support\Facades\Auth;
//use App\User;
use Illuminate\Foundation\Auth\User;
use App\ReportSpeed;
use App\Treck;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;


class OverSpeedController extends Controller
{
    public  function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
//        dd($request->user());
        //Ключь в сесию
        $hash = getHashRomApi();
        $reportId = $request->get('id');

//        $date1 = '2020-05-17 00:00:00';
//        $date2 = '2020-05-23 23:59:59';

        //Запрос списка сформирванных отчетов
        $paramData = [
            'hash' => $hash,
        ];
        $reportsList = getReports($paramData, 'Отчет_сформированные_список');

        $viwParam['list'] = $reportsList['list'];

        //Получение id первого отчета в списке
        if (!$reportId)
            $reportId = $reportsList['list'][0]['id'];

        //Получение списка треков в отчете по id
        $paramData = [
            'hash' => $hash,
            'report_id' => $reportId
        ];
        $reportTrack = getReports($paramData, 'Получить_готовый_отчет');

        //Подготовка данных для Вида
        if ($reportTrack) {
            $viwParam['report_id'] = $reportId; //id - текущий отчет
            $viwParam['report'] = $reportTrack['report']; //Отчет
        }

        // $list - списка отчетов ,
        // $report_id - id отчета,
        // $report - список треков
        return view('over_speed.index', $viwParam);
    }

    /**
     * Для запуска по расписанию. Закружает отчеты и треки в базу
     */
    public function reconciliation_reports(){
        set_time_limit(48 * 60);
        $path_parts = pathinfo($_SERVER['SCRIPT_FILENAME']); // определяем директорию скрипта
        chdir($path_parts['dirname']); // задаем директорию выполнение скрипта

        $fd = fopen("log_schedule.txt", 'a') or die("не удалось создать файл");

        //Ключь в сесию
        $hash = getHashRomApi();
        //$reportId = null;//$request->get('id');

        //Запрос списка сформирванных отчетов
        $paramData = [
            'hash' => $hash,
        ];
        $reports_list = getReports($paramData, 'Отчет_сформированные_список');
        Log::info('OverSpidReports начинаю загрузку ');
        $str = "\nOverSpidReports начинаю загрузку ";
        // TODO: Все ли отчеты в базе
        foreach ($reports_list['list'] as $list){
            $value = ReportSpeed::where('number', $list['id'])->exists();
            if(!$value) {
                Log::info('__Загружаю треки по отчету: '.$list['id']);
                $str .= "\n__Загружаю треки по отчету: ".$list['id'];

                // TODO: Получить трек
                //Получение списка треков в отчете по id
                $paramData = [
                    'hash' => $hash,
                    'report_id' => $list['id']
                ];
                $report_tracks = getReports($paramData, 'Получить_готовый_отчет');
                Log::info('____Количество треков: '.count($report_tracks['report']['sheets']));
                $str .= "\n____Количество треков: ".count($report_tracks['report']['sheets']);

                // TODO: Записать трек в базу
                if($report_tracks['success']){
                    $report=getArrayTrack($report_tracks['report'],false);
                    Log::info('____Количество записей: '.count($report));
                    $str .= '\n____Количество записей: '.count($report);
                    save_track($report, $list['id']);
                }

                // TODO: Если успешно записать отчет в базу
                $save_treck = true;
                if( $save_treck){
                    save_report($list);
                Log::info('__Треки по отчету '.$list['id']." загружены  ".\Carbon\Carbon::now());
                $str .= "\n__Треки по отчету ".$list['id']." загружены  ".\Carbon\Carbon::now();
                }

            }
        }
        fwrite($fd, $str);
        fclose($fd);

    }

    public function speed_reports(Request $request)
    {
        $report_id = $request->get('id');
        //Запрос списка сформирванных отчетов
        $reports_list = ReportSpeed::all()->sortByDesc('number');

        //Получение id первого отчета в списке
        if(! $report_id and count($reports_list) > 0) $report_id = $reports_list->first()->number ;//echo "Что то пошло не так"; //
		else redirect()->route('speed_report')->with(['status' => 'База данных не доступна или не содержит данных.' ]);

        //Получение списка треков в отчете по id c группировкой по трекам
        $dravers = Treck::where('report_id',$report_id)
            ->orderBy('max_speed', 'desc')
            ->get()->groupBy('header');

        //Получение списка треков в отчете по id
        $report_track = Treck::where('report_id',$report_id)
            ->orderBy('max_speed', 'desc')
            ->get();

        //Подготовка данных для Вида
        if ($report_track) {
            $viwParam['list'] = $reports_list; // Полный список полученных отчетов
            $viwParam['dravers'] = $dravers; //Отчеты сгрупированные по водителям
            $viwParam['report_id'] = $report_id; //id - текущиего отчета
            $viwParam['reports'] = $report_track; //Треки текущего отчета сортированные по скоростям
        }
        return view('speed_report.index', $viwParam);
    }

}
