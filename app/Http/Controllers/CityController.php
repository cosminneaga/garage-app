<?php

namespace App\Http\Controllers;

use App\Models\World\Record;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function index(Request $request)
    {
        return Record::first()->country;
    }
}
