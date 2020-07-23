<?php
/************
 * Проба чтения Excel
 ***********/

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Thybag\SharePointAPI;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as RXlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx as WXlsx;
use RuntimeException;
use Throwable;
use App\GasStation;
use Illuminate\Support\Facades\Log;

class GetxlsController extends Controller
{
    public  function __construct()    {
        $this->middleware('auth');
    }
    public function saveExcel()
    {
        $path_parts = pathinfo($_SERVER['SCRIPT_FILENAME']); // определяем директорию скрипта
        chdir($path_parts['dirname']); // задаем директорию выполнение скрипта
        try {
            $path = 'gas_station/';
            $files = scandir($path); //присваиваем переменной массив с листингом директории
            foreach($files as $sFile) //проходим по массиву
                if(!is_dir($path . $sFile)) { //если это файл, а не папка
                    $oSpreadsheet = IOFactory::load($path . $sFile);
                    $oCells = $oSpreadsheet->getActiveSheet()->getCellCollection();
                    $oCell = $oCells->get("A1");
                    if ($oCell) $A1 = $oCell->getValue();
                    if ($A1 == "Клиент: Общество с ограниченной ответственностью \"Тимбермаш Байкал\"") {
                        for ($iRow = 2; $iRow <= $oCells->getHighestRow(); $iRow++) {
                            $oCell = $oCells->get("A" . $iRow);
                            if ($oCell) {
                                $cell = $oCell->getValue();
                                if (mb_strpos($cell, 'по карте')) {
                                    $iRow = $iRow + 2;
                                    while (true) {
                                        $gas_station = new GasStation();
                                        $cell = $oCells->get('A' . $iRow);
                                        $dCell = $cell->getValue();
                                        // Конец текущего блока заправок
                                        if (mb_strpos($dCell, 'того')) break;
                                        // Если ячека даты не пустая и число
                                        if (gettype($dCell) == 'integer') {
                                            $date = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($dCell);
                                            $gas_station->date = $date;
                                            ////if (mb_strpos($date, 'того')) break;
                                            //if(get_class($date) == 'DataTime'){
                                            $gas_station->qty = $oCells->get('C' . $iRow)->getValue();
                                            $gas_station->service = $oCells->get('H' . $iRow)->getValue();
                                            $gas_station->operation = $oCells->get('I' . $iRow)->getValue();
                                            $gas_station->card_owner = $oCells->get('K' . $iRow)->getValue();
                                            $gas_station->card_number = $oCells->get('J' . $iRow)->getValue();
                                            $gas_station->card_group = $oCells->get('L' . $iRow)->getValue();
                                            $gas_station->time = $oCells->get('B' . $iRow)->getValue();
                                            $gas_station->amount = $oCells->get('D' . $iRow)->getValue();
                                            // Если такая запись уже есть в базе
                                            $gs_exist = GasStation::where('card_number', $gas_station->card_number)
                                                ->where('date', date('Y-m-d', strtotime($gas_station->date)))
                                                ->where('time', $gas_station->time)
                                                ->first();
                                            if ($gs_exist) break;
                                            $gas_station->save();
                                        }

                                        $iRow++;
                                    }
                                }
                            }
                        }
                        Log::info("saveExcel -- $path . $sFile -- файл загружен");
                        echo "saveExcel -- $path . $sFile -- файл загружен";

                    } else {
                        Log::info("saveExcel -- $path . $sFile -- не верный файл");
                        echo "saveExcel -- $path . $sFile -- не верный файл";
                    }
                    if (unlink($path . $sFile)) {
                        Log::info("saveExcel -- $path . $sFile -- удален");
                        echo "saveExcel -- $path . $sFile -- удален";
                    }
                    else {
                        Log::info("saveExcel -- $path . $sFile -- не удален");
                        echo "saveExcel -- $path . $sFile -- не удален";
                    }
                }
            echo "В папке $path, ".count($files)."шт. отчетов загруженны";
            Log::info("В папке $path, ".count($files)."шт. отчетов загруженны");
        }
        catch (Throwable $e){
            Log::info("saveExcel -- Ошибка -- ".$e.'!!!');
            echo "saveExcel -- Ошибка -- ".$e.'!!!';
            Log::info("saveExcel -- !!! $path_parts".implode($path_parts).'!!!');
            echo "saveExcel -- !!! $path_parts".implode($path_parts).'!!!';
        }
    }
}








