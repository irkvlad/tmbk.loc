<?php

return [
    /*
    |------------------------------
    |
    |------------------------------
    |
    */
    'spid1'=>110,
    'spid2'=>120,
    'spid3'=>130,
    'emls' => ['irkvlad@hotmail.com'],
    'pathGas' => 'public/files/gas',
    'pathReps' => 'public/files/reps',
    'urlTrackApi' => 'http://api.navixy.com/v2/',
    'urlTrack' => 'https://my.gdemoi.ru/#/pro-ui/reports',
    'login' => 'irkvlad@hotmail.com',//'J@tmbk.ru',//
    'pasword' =>'scoraya911', //'West128',//
    'apiCommand' =>[
        'Список_отделов'=>'department/list',
        'Отчеты_расписания_список'=>'report/schedule/list',
        'Отчет_сформированные_список'=>'report/tracker/list',
        'driver_journal_entry_list'=>'driver/journal/entry/list',
        'rule'=>'rule/list',
        'Список_маякчков'=>'tracker/list', //маякчек_по_названию
        'Список_групп'=>'tracker/group/list', //названия цвета коды
        'transaction_list'=>'transaction/list',
        'vehicle_list'=>'vehicle/list',
        'track_list'=>'track/list',
        'Получить_трек'=>'track/read',
        'Получить_готовый_отчет'=>'report/tracker/retrieve'
    ]
];
