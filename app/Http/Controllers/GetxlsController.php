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
        try {
            $sFile = 'gas_station/gas_station.xls';
            $oSpreadsheet = IOFactory::load($sFile);
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
                                $dCell= $cell->getValue();
                                // Конец текущего блока заправок
                                if(mb_strpos($dCell, 'того')) break;
                                // Если ячека даты не пустая и число
                                if( gettype($dCell) == 'integer'){
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
                Log::info('saveExcel -- gas_station/gas_station.xls -- файл загружен');

            } else {
                Log::info('saveExcel -- gas_station/gas_station.xls -- не верный файл');
            }
            if (unlink('gas_station/gas_station.xls'))
                Log::info('saveExcel -- gas_station/gas_station.xls -- удален');
            else
                Log::info('saveExcel -- gas_station/gas_station.xls -- не удален');
        }
        catch (Throwable $e){
            Log::info('saveExcel -- gas_station/gas_station.xls -- Ошибка -- '.$e);
    }
    }
}








