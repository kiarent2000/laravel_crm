<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PriceCalculateService;

class ServiceTestController extends Controller
{
    public function index(Request $request, PriceCalculateService $service)
    {
       dd($service->plus($request->all()));
    }
}
