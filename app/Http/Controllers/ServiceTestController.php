<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PriceCalculateService;
use App\Facades\Price;

class ServiceTestController extends Controller
{
  /*  public function index(Request $request, PriceCalculateService $service)
    {
       //dd($service->plus($request->all()));
    }
    */

    public function index(Request $request)
    {
        //dd(app('price')->plus($request->all()));
        dd(Price::plus($request->all()));
    }
}
