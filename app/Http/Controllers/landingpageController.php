<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class landingpageController extends Controller
{
    //
    public function landingpage()
    {
        return view('pages.landingpage');
    }
}
