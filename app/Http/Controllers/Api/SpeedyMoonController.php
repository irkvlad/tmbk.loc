<?php


namespace App\Http\Controllers\Api;

use \App\Http\Controllers\Api\Controller;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use App\Treck;
use App\User;
use DateTime;
use Validator;

class SpeedyMoonController extends Controller
{

    public function getMoon(){
        try {
            $user = auth()->userOrFail();
        } catch (\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e) {
             return response()->json(['error' => true, 'message'=> 'Incorrect login'], 401);
        }

        $lastDey = date("Y-m-t", strtotime("-1 month"));
        $ferstDey = date("Y-m-01", strtotime("-1 month"));

    return response()->json(Treck::
        where('date_track','<',$lastDey)
        ->where('date_track','>',$ferstDey)
        ->orderBy('date_track', 'desc')
        ->get()
        ->groupBy('header')
    );
    }

 public function getWeek(){
     try {
         $user = auth()->userOrFail();
     } catch (\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e) {
         return response()->json(['error' => true, 'message'=> 'Incorrect login'], 401);
     }

     $LastWeek = new DateTime('Monday last week');
     $ThisWeek = new DateTime('Monday this week');

    return response()->json(Treck::
        where('date_track','<',$ThisWeek->format("Y-m-d"))
        ->where('date_track','>',$LastWeek->format("Y-m-d"))
        ->orderBy('date_track', 'desc')
        ->get()
        ->groupBy('header')
    );
    }

 public function getDay(){
     try {
         $user = auth()->userOrFail();
     } catch (\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e) {
         return response()->json(['error' => true, 'message'=> 'Incorrect login'], 401);
     }


        $endDey = date("Y-m-d", strtotime("-1 day"));

    return response()->json(Treck::
        where('date_track','=',$endDey)
       // ->where('date_track','>',$ferstDey)
        ->orderBy('max_speed', 'desc')
        ->get()
        ->groupBy('header')
    );
    }
}
