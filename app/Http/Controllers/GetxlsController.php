<?php
/************
 * Проба чтения Excel
 ***********/

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//error_reporting(E_ALL);
//ini_set('display_errors', 'On');
//require_once('vendor/autoload.php');
// Класс, непосредственно читающий файл
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as RXlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx as WXlsx;

class GetxlsController extends Controller
{

    public function testPhp(){

        var_dump(password_hash('022963', PASSWORD_DEFAULT));

    }
    public function show()
    {
        $file = 'c:\test.xlsx';

        //$sFile = 'in.xlsx';
        //--$oReader = new Xlsx();
        $oSpreadsheet = IOFactory::load($file); // Вариант и для xls и xlsX

        // Если вы хотите установить строки и столбцы, которые необходимо читать, создайте класс ReadFilter
        //$oReader->setReadFilter( new MyReadFilter(11, 1000, range('B', 'O')) );

        //$oSpreadsheet = $oReader->load($sFile);

        $oCells = $oSpreadsheet->getActiveSheet()->getCellCollection();

        for ($iRow = 1; $iRow <= $oCells->getHighestRow(); $iRow++)
        {
            //for ($iCol = 'A'; $iCol <= 'C'; $iCol++)
            for ($iCol = 'A'; $iCol <= $oCells->getHighestColumn(); $iCol++)
            {
                $oCell = $oCells->get($iCol.$iRow);
                if($oCell)
                {
                    echo $oCell->getValue() . '<br />';
                }
            }
            echo  '<hr />';
        }

       /* // Создаём ридер
        $reader = new Xlsx();
        // Если вы не знаете, какой будет формат файла, можно сделать ридер универсальным:
        // $reader = IOFactory::createReaderForFile($file);
        // $reader->setReadDataOnly(true);

        // Если вы хотите установить строки и столбцы, которые необходимо читать, создайте класс ReadFilter
       // $reader->setReadFilter(new MyReadFilter(11, 1000, range('B', 'O')));

        // Читаем файл и записываем информацию в переменную
        $spreadsheet = $reader->load($file);

        // Так можно достать объект Cells, имеющий доступ к содержимому ячеек
        $cells = $spreadsheet->getActiveSheet()->getCellCollection();
        $col1 =  $cells->getHighestRow();
        //var_dump($cells);
        // Далее перебираем все заполненные строки (столбцы B - O)
        try {
            for ($row = 0; $row <= $col1; $row++) {
            for ($col = 'A'; $col <= 'O'; $col++) {
                // Так можно получить значение конкретной ячейки

                   $cell = $cells->get($col . $row)->getValue();
                    var_dump($cell);
                   $celly = $cell ->getValue();
                    var_dump($celly);
                // а также здесь можно поместить ваш функциональный код
            }
            }
        }
        catch (Exception $e) {
            echo $e->getMessage();
            echo '<br /><pre>';
            print_r($cells);
            echo '</pre><br />';
        }
        catch (Throwable $e) {
            echo $e->getMessage();
            echo '<br /><pre>';
            print_r($cells);
            echo '</pre><br />';
        }/**/
      /*  echo '<br /><pre>';
        print_r($cells);
        echo '</pre><br />';*/

       // return true;
    }
    public function PHPEchelHelpWord()
    {
        echo '<h1>Создаю тестовый отчет "Ну привет Вася с круговой диаграммой </h1>';
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet = $reader->load("./Отчет по превышениям скорости (Шаблон).xlsx");
        //$spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Отчет Вася В111СЯ');
        $sheet->setCellValue('B3', 10);
        $sheet->setCellValue('B4', 5);
        $sheet->setCellValue('B5', 3);
        $sheet->setCellValue('B6', 20);
        $sheet->setCellValue('F21', 'Ну привет вася !!!');

        $writer = new WXlsx($spreadsheet);
        $writer->save('Отчет по превышениям скорости.xlsx');
        echo 'отчет создан: <a href:"./Отчет по превышениям скорости.xlsx"> Открыть</a>';
    }
}








