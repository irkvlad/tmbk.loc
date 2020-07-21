<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GasStation extends Model
{
    protected $fillable = [
        'date'
        ,'qty'
        ,'service'
        ,'operation'
        ,'card_number'
        ,'card_owner'
        ,'card_group'
        ,'time'
        ,'amount'
        ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'date',
    ];
}
