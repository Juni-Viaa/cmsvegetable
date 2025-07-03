<?php

namespace App\Http\Controllers;
use App\Http\Requests\StoreTeamRequest;
use App\Http\Requests\UpdateTeamRequest;
use App\Models\OurPrinciple;
use App\Models\OurTeam;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class AboutusController extends Controller
{
    public function aboutus(){
        $teams = OurTeam::all()->take(6);
        $sprinciples = OurPrinciple::take(4)->get();
        return view('pages.aboutus', compact('teams', 'sprinciples'));
    }

}