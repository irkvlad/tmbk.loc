<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Treck extends Model
{
    //
    protected $fillable = [
        'device_track_id'
        ,'data_header'
        ,'start_time'
        ,'duration'
        ,'max_speed'
        ,'avg_speed'
        ,'title'
        ,'header'
        ,'header_id'
        ,'max_speed_address'
        ,'max_speed_lat'
        ,'max_speed_lng'
        ,'report_id'
        ,'date_track'
    ];
}
