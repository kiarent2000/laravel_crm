<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ServiceTestController extends Controller
{
    public function index(Request $request)
    {
       dd($request);
    }
}
