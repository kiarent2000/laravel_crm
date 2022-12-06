<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ServiceTestController extends Controller
{
    public function index(Request $request, PriceCalculateService $service)
    {
       dd($service->plus($request->all()));
    }
}
