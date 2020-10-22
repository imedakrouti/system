<?php

namespace App\Http\Controllers;
use App\Http\Traits\PDF_Converter;
use Illuminate\Http\Request;
use Student\Models\Settings\Grade;
use PDF;
use Student\Models\Settings\Design;
use Student\Models\Students\Student;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
        
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }


}
