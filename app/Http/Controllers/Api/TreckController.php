<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Treck;

class TreckController extends Controller
{
    public function index()
    {
        return Treck::all();
    }

    public function show(Treck $treck)
    {
        return $treck;
    }
}
