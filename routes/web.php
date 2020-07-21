<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Здесь вы можете зарегистрировать веб-маршруты для вашего приложения. Эти
| маршруты загружаются RouteServiceProvider в группе, которая
| содержит группу промежуточного программного обеспечения "web" Теперь создайте что-то великое!
|
*/

Auth::routes(['register' => false]);//['register' => false]
Route::get('passwords/expired', 'Auth\ExpiredPasswordController@expired')->name('password.expired');
Route::post('password/expired', 'Auth\ExpiredPasswordController@postExpired')->name('password.postExpired');

Route::middleware(['password_expired'])->group(function () {
    Route::get('speed_report', 'OverSpeedController@index')->name('speed_report'); //Трекер отчеты
    Route::get('rec_rep.php', 'OverSpeedController@reconciliation_reports'); //Трекер отчеты
    Route::get('/', 'OverSpeedController@speed_reports')->name('home'); //Трекер отчеты
    Route::get('getxls', 'GetxlsController@saveExcel'); //Чтения XLS отчета заправок и запись в базу
    Route::get('gas_report', 'GasController@show_reports')->name('gas_report'); //Трекер отчеты
    Route::post('gas_report', 'GasController@show_reports')->name('gas_report'); //Трекер отчеты
});

/*
 * Родная Аутентификация
 */
//Auth::routes();
//Route::get('/home', 'HomeController@index')->name('home');

/*Route::get('/', function () { //Стандартный Велком Ларавеля
    return view('welcome');
});*/

/*
/-----------------------------------------------------------------
/Тестовые ссылки
/----------------------------------------------------------------
/
*/
//Route::get('tracker', 'TrackController@index')->name('published_at'); //Трекер отчеты
//Route::get('tracker/{id}', 'TrackController@index'); // Получение отчета
//Route::get('tracker', 'TrackController@index'); //Трекер отчеты


//Route::get('PHPEchelHelpWord', 'GetxlsController@PHPEchelHelpWord'); //Чтение HASH

//Route::get('/test', 'TestTrackReport@show')->name('test')->middleware('auth');//Функции API
//Route::get('test/{page}', ['uses'=>'TestTrackReport@page','as'=>'article','middleware'=>'mymiddle']);





