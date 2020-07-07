<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers;
use App\GasStation;
use Illuminate\Http\Request;
use App\Http\Requests;

class LoadGasStation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'load_gas_station';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Запуск загрузчика отчетов';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        $path_parts = pathinfo($_SERVER['SCRIPT_FILENAME']); // определяем директорию скрипта
        chdir($path_parts['dirname']); // задаем директорию выполнение скрипта
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $fd = fopen("log_gas_station.txt", 'w') or die("не удалось создать файл");
        $str = "Автостарт load_gas_station ".date("m.d.y H:i");
        fwrite($fd, $str);
        fclose($fd);

        $controller = new \App\Http\Controllers\GetxlsController();
        $controller->saveExcel();
        Log::info('Отчет GasStation загружен ============================= ');

        $fd = fopen("log_schedule.txt", 'a') or die("не удалось создать файл");
        $str = "\nОтчет GasStation загружен ============================= ";
        fwrite($fd, $str);
        fclose($fd);
    }
}
