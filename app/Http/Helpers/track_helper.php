<?php

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;
use PHPUnit\Util\Json;
use App\ReportSpeed;
use App\Treck;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Psr7;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use PhpParser\Node\Stmt\Foreach_;

use App\Http\Helpers\TrackHelper;
use Illuminate\Support\Facades\Auth;
//use App\User;
use Illuminate\Foundation\Auth\User;
use App\Exceptions\Handler;


function test_help(){
        echo 'Test Helpper is worck!';
    }

/**
 * Замена ключа в массиве. Работает по ссылке на массив
 * string $key,
 * string $new_key,
 * array &$arr
 */
function change_key($key,$new_key,&$arr,$rewrite=true){
    if(!array_key_exists($new_key,$arr) || $rewrite){
        $arr[$new_key]=$arr[$key];
        unset($arr[$key]);
        return true;
    }
    return false;
}

/**
 * Сортировка по убыванию строки отчета по превышению
 * @param array $rows
 * @param string $key
 */
function sort_row_traks(array &$rows,$key=''){

        $step=null;
        for($i = 0; $i < count($rows)-1; $i++)
            for($j=0; $j < count($rows)-1-$i;$j++){
                if($rows[$j+1]['max_speed']['raw'] > $rows[$j]['max_speed']['raw']){
                    $step = $rows[$j];
                    $rows[$j] = $rows[$j+1];
                    $rows[$j+1] = $step;
                }
            }
    }

/**
 * Получить данные группы в которую входит маячок
 * @param string label of trecker
 * @return array treck_group|null
 */
function getGroupLabel_by_tracer_id($label){
    $group['title']="Без группы";
    $group['id']="0";
    $hash = getHashRomApi();
    $paramData = [
        'hash' => $hash
    ];
    $groupList = getReports($paramData, 'Список_групп');
    $path =  '?labels=["'.$label.'"]';
    $paramData = [
        'hash' => $hash
    ];
    $group_id = getReports($paramData, 'Список_маякчков',$path);
    if(isset($group_id["list"][0]["group_id"])and $group_id["list"][0]["group_id"]>0)
        foreach ($groupList['list'] as $group)
            if($group['id'] == $group_id["list"][0]["group_id"])
                return $group;
     return $group;
}

/**
 * Получить ID маячка по его наименованию
 * @param string label of trecker
 * @return string  device_id|null
 */
function getDevice_id_by_label($label){
    $device_id = null;
    $hash = getHashRomApi();
    $paramData = [
        'hash' => $hash
    ];
    $groupList = getReports($paramData, 'Список_групп');
    $path =  '?labels=["'.$label.'"]';
    $paramData = [
        'hash' => $hash
    ];
    $group_id = getReports($paramData, 'Список_маякчков',$path);

    if(isset($group_id["list"][0]["group_id"])and $group_id["list"][0]["group_id"]>0)
       $device_id= $group_id['list'][0]['source']['device_id'];

    return $device_id;
}

/**
 * Получить API ключ
 * Необходима библиотека Guzzle, Json
 * use GuzzleHttp\Client;use GuzzleHttp\RequestOptions;use GuzzleHttp\Psr7;use GuzzleHttp\Exception\RequestException;use PHPUnit\Util\Json;
 *  @param string $urlTrackApi  Адресная строка для авторизации
 *  @param string $login Логин
 *  @param string $password Пароль
 * @return string  $hash API Ключ
 **/
function getHash()
{
    // Иницилизация параметров запроса
    $client = new Client();
    $urlTrackApi= Config::get('track.urlTrackApi').'user/auth/';
    $postData = [
        'login' => Config::get('track.login'),
        'password' => Config::get('track.pasword')
    ];
    //Построение запроса Guzzle
    $response = $client->request(
        'post',
        $urlTrackApi,
        [
            'form_params' => $postData
        ]
    );
    //Декодирование запроса в массив
    $json = json_decode($response->getBody());
    if ($json->success)
        return $json->hash;
    return null;
}

/**
 * Запрос списка сформирванных отчетов
 * @param array $paramData ['hash'=> $hash,'from' => $date1,'to'=> $date2]
 * @return Json
 */
function getReports(array $paramData, string $command,$path='')
{
    $apiComand = getApiCommand($command);
    $urlTrackApi = Config::get('track.urlTrackApi');
    $json = getJison($urlTrackApi . $apiComand . $path, $paramData);
    if ($json['success'])             return $json;
//    var_dump(['path'=>$urlTrackApi . $apiComand,'paramData'=>$paramData,'command'=>$command]);
    return null;
}

/**
 * Получить Api запрос
 * @param string $path Адресная строка запроса
 * @param string $hash API Ключ
 * @param Array $paramData 'hash'=> 'кешь ключ', 'from' => 'Начальная дата', 'to'=>'Конечная дата'
 * @param string $metod Метод запроса POST/GET
 * @return string  $json Объект JSON ответ API ($json->success=false/true)
 */
function getJison( string $path, array $paramData= null) {
    $json=new Json();
    $client = new Client();
    try{
        $response = $client->request(
            'post',
            $path,
            [
                'form_params' => $paramData
            ]
        );
        return json_decode($response->getBody(),'JSON_THROW_ON_ERROR' ); }
        //return $response->getBody(); }
        //Перехватываем (catch) исключение, если что-то идет не так.
    catch (RequestException $e) {
        echo Psr7\str($e->getRequest());
        if ($e->hasResponse()) {
            echo Psr7\str($e->getResponse());
            return  ['success'=>false];
        }
    }
    return   ['success'=>false];
}

/**
 * Список API команд ресурса ГдеМои
 */
function getApiCommand(string $command){
    $apiComand=	Config::get('track.apiCommand');
    if (array_key_exists($command,$apiComand) ) return $apiComand[$command];
    return false;
}

/**
 * Получить Api ключ из сесии
 * @return \Illuminate\Session\SessionManager|\Illuminate\Session\Store|mixed|string
 */
function getHashRomApi(){
    $hash = session('hash');
    if( !$hash ) $hash = getHash();
    session(['hash' => $hash  ] );
    return $hash;
}


function getArrayTrack($reports,$flag=true){
       $reps=array();
       $index_rep=0;
       $sheets = $reports['sheets'];
       foreach($sheets as $sheet){
            $_header = $sheet['header'];
            $_entity_ids = $sheet['entity_ids'][0];
            if(!$_header) $_header="Без названия";
            $_group = getGroupLabel_by_tracer_id($_header);
           try {
               foreach ($sheet['sections'] as $section) {
                   if ($section['type'] == 'table') {
                       foreach ($section['data'] as $data) {
                           foreach ($data['rows'] as $row) {
                               if ($row['max_speed']['v'] < 110) continue;
                               $reps[$index_rep]['data_header'] = $data['header'];
                               $reps[$index_rep]['start_time'] = $row['start_time']['v'];
                               $reps[$index_rep]['duration'] = $row['duration']['v'];
                               $reps[$index_rep]['avg_speed'] = $row['avg_speed']['v'];
                               $reps[$index_rep]['max_speed'] = $row['max_speed']['v'];
                               $reps[$index_rep]['max_speed_address'] = $row['max_speed_address']['v'];
                               $reps[$index_rep]['max_speed_lat'] = $row['max_speed_address']['location']['lat'];
                               $reps[$index_rep]['max_speed_lng'] = $row['max_speed_address']['location']['lng'];
                               $reps[$index_rep]['title'] = $_group['title'];
                               $reps[$index_rep]['header'] = $_header;
                               $reps[$index_rep]['entity_ids'] = $_entity_ids;
                               $index_rep++;
                           }
                       }
                   }
               }
           }
           catch (Throwable $e) {
               report($e);
               return $reps;
           }
       }
       if($flag) array_multisort(array_column($reps, 'max_speed'), SORT_DESC, $reps);
       return $reps;
}

function save_report($list){
    $rep_spp = ReportSpeed::create([
        'number' => $list['id']
        ,'title' => $list['title']
        ,'from' => $list['from']
        ,'to' => $list['to']
        ]);
    return $rep_spp;
}

function save_track($list,$report_id){
    $i=0;
    foreach($list as $treck) {
        $device_id = getDevice_id_by_label($treck['header']);
        $device_track_id = mb_substr($treck['data_header'], 0, 10) . ' ' . $treck['start_time'].'#'.$device_id;
        $rep_spp = Treck::firstOrCreate([
            'device_track_id' => $device_track_id
            , 'data_header' => $treck['data_header']
            , 'start_time' => $treck['start_time']
            , 'duration' => $treck['duration']
            , 'max_speed' => $treck['max_speed']
            , 'avg_speed' => $treck['avg_speed']
            , 'title' => $treck['title']
            , 'header' => $treck['header']
            , 'header_id' => $treck['entity_ids']
            , 'max_speed_address' => $treck['max_speed_address']
            , 'max_speed_lat' => $treck['max_speed_lat']
            , 'max_speed_lng' => $treck['max_speed_lng']
            , 'report_id' => $report_id
        ]);
        $i++;
    }
    return $rep_spp;
}

//Не забудь про: composer dump-autoload
