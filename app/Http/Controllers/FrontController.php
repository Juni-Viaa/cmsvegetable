<?php

namespace App\Http\Controllers;

use App\Models\HeroSection;
use App\Models\CompanyStatistic;
use App\Models\OurPrinciple;
use App\Models\Testimonial;
use App\Models\OurTeam;
use App\Models\Showcase;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    //
    public function index()
    {
        $hero_section = HeroSection::orderByDesc('hero_id')->take(1)->get();
        $statistics = CompanyStatistic::take(4)->get();
        $principles = OurPrinciple::take(4)->get();
        $showcases = Showcase::take(4)->get();
        $testimonials = Testimonial::take(5)->get();
        $teams = OurTeam::take(7)->get();
        return view('front.index', compact('hero_section', 'statistics', 'principles', 'showcases', 'testimonials', 'teams'));
    }

    public function team()
    {
        $teams = OurTeam::take(7)->get();
        $statistics = CompanyStatistic::take(4)->get();
        return view('front.team', compact('teams', 'statistics'));
    }
}
