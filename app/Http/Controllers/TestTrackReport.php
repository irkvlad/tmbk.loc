<?php

namespace App\Http\Controllers;

use http\Url;
use Illuminate\Http\Request;
use Config;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\RequestException;
use PHPUnit\Util\Json;
use Illuminate\Support\Facades\DB;

class TestTrackReport extends Controller
{

    public function show(){
        echo 'Show';

        $collection = collect([
            ['name' => 'Desk', 'price' => 200],
            ['name' => 'Chair', 'price' => 100],
            ['name' => 'Bookcase', 'price' => 150],
        ]);

        $sorted = $collection->sortBy('price');

        $sorted->values()->all();
        dump($sorted);
    }

    public function page($page){
        echo 'page';
    }
}
