<?php

namespace App\Http\Controllers;

error_reporting(E_ALL);
ini_set('display_errors', 'On');

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7;
use Illuminate\Http\Request;
use App\Http\Requests;
use PHPUnit\Util\Json;
use Config;
use App\Http\Helpers\TrackHelper;
use App\Http\Controllers\Controller;

class TrackController extends Controller
{
    public function index(Request $request)
    {
        //Ключь в сесию
        $hash = null;//session('hash');
        if( !$hash ) $hash = $this->getHash();
        session(['hash' => $hash  ] );
        $reportId = $request->get('id');

        $date1 = '2020-05-17 00:00:00';
        $date2 = '2020-05-23 23:59:59';

        //Запрос списка сформирванных отчетов
        $paramData=[
            'hash'=> $hash,
        ];
        $reportsList = $this->getReports($paramData,'Отчет_сформированные_список');
        $viwParam['reports'] = $reportsList['list'];
//dd($reportsList);
        //Получение отчета
        if($reportId) {
            $paramData = [
                'hash' => $hash,
                'report_id' => $reportId
            ];
            $reportTrack = $this->getReports($paramData, 'Получить_готовый_отчет');   //5130674 5130674
           if($reportTrack) {
               $trRows = $reportTrack['report']['sheets'][0]['sections'][0]['data'][0]['rows'];
               $viwParam['report_id'] = $reportId;
               $viwParam['reportTrack'] = $reportTrack['report'];
               $viwParam['trRows'] = $trRows;
           }
        }

        return view('track.index', $viwParam );
    }


    /*
     * Необходима библиотека Guzzle, Json
     * use GuzzleHttp\Client;use GuzzleHttp\RequestOptions;use GuzzleHttp\Psr7;use GuzzleHttp\Exception\RequestException;use PHPUnit\Util\Json;
     *  @param string $urlTrackApi  Адресная строка для авторизации
     *  @param string $login Логин
     *  @param string $password Пароль
     * @return string  $hash API Ключ
     */
    protected function getHash()
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
    protected function getReports(array $paramData, string $command,$path='')
    {
        $apiComand = $this->getApiCommand($command);
        $urlTrackApi = Config::get('track.urlTrackApi');
        $json = $this->getJison($urlTrackApi . $apiComand . $path, $paramData);
        if ($json['success'])             return $json;
        var_dump(['path'=>$urlTrackApi . $apiComand,'paramData'=>$paramData,'command'=>$command]);
        return null;
    }

    /*
    * @param string $path Адресная строка запроса
    * @param string $hash API Ключ
    * @param Array $paramData 'hash'=> 'кешь ключ', 'from' => 'Начальная дата', 'to'=>'Конечная дата'
    * @param string $metod Метод запроса POST/GET
    * @return string  $json Объект JSON ответ API ($json->success=false/true)
    */
    protected function getJison( string $path, array $paramData= null) {
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
            return json_decode($response->getBody(),JSON_THROW_ON_ERROR ); }
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

    /*
     * Список API команд ресурса ГдеМои
     */
    protected function getApiCommand(string $command){
        $apiComand=	Config::get('track.apiCommand');
        if (array_key_exists($command,$apiComand) ) return $apiComand[$command];
        return false;
    }
}
