<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

class PagesController extends Controller
{
    public function home()
    {
        return view('welcome');
    }
}
