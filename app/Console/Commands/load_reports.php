<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers;
use App\ReportSpeed;
use App\Treck;
use Illuminate\Http\Request;
use App\Http\Requests;

class LoadReports extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'load_reports';

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
        $fd = fopen("log_schedule.txt", 'w') or die("не удалось создать файл");
        $str = "Автостарт load_reports ".date("m.d.y H:i");
        fwrite($fd, $str);
        fclose($fd);

        $controller = new \App\Http\Controllers\OverSpeedController();
        $controller->reconciliation_reports();
        Log::info('Отчеты ReporTracks загружены ============================= ');

        $fd = fopen("log_schedule.txt", 'a') or die("не удалось создать файл");
        $str = "\nОтчеты ReporTracks загружены ============================= ";
        fwrite($fd, $str);
        fclose($fd);
    }
}
