<?php

namespace App\Http\Controllers;
use App\Http\Traits\PDF_Converter;
use Illuminate\Http\Request;
use Student\Models\Settings\Grade;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
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
    public function testExportPdf()
    {
        $fileBladePath = 'test-pdf';
        $data = Grade::all();
        $titleFile = 'title file';
        $display = 'stream';
        $filename = 'trial.pdf';
        $rtl = true;
        

        PDF_Converter::getPDFFile($fileBladePath,$data,$titleFile,$display,$filename,$rtl);
    }

}
