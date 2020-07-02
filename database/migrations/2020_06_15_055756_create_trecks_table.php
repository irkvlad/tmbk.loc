<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrecksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trecks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('device_track_id');     // Сводная из data_header и start_time - метка времени происшествия
            $table->string('data_header');          /* 07.04.2020 (Вт) : 7 */
            $table->string('start_time');           /*15:04*/
            $table->string('duration');             /*00:04*/
            $table->float('max_speed');             /* 170 */
            $table->float('avg_speed');             /* 60 */
            $table->string('title');                /* Барнаул - группа */
            $table->string('header');               /*В099ВА 138 Hiluxe Рудов М.*/
            $table->integer('header_id');               /*В099ВА 138 Hiluxe Рудов М.*/
            $table->string('max_speed_address');    /*ссылка на карту*/
            $table->float('max_speed_lat');         /*ссылка на карту*/
            $table->float('max_speed_lng');         /*ссылка на карту*/
            $table->string('report_id');            /*Номер отчета*/
            $table->timestamps();
            $table->dateTime('date_track');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trecks');
    }
}
