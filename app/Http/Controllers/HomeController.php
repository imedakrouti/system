<?php

namespace App\Http\Controllers;
use App\Http\Traits\PDF_Converter;
use Illuminate\Http\Request;
use Student\Models\Settings\Grade;
use PDF;

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
    public function testExportPdf()
    {  

        $data = [
			'foo' => 'bar'
		];
		$pdf = PDF::loadView('test-pdf', $data);
		return $pdf->stream('test-pdf');
    }

}
