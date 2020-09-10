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
    public function testExportPdf()
    {  
        $students = Student::with('father','division','grade','mother')
        ->where('student_image','<>','null')
        ->get();
        $design  = Design::orderBy('id','desc')->first()->design_name;
        $data = [
            'schoolName'        => settingHelper()->ar_school_name,
            'path'              => public_path('storage/icon/Fpp0u5uXWs3o4vk9wn2hLJhMol3704IoVPXGT0CZ.png'),
            'design'            => public_path('storage/id-designs/'.$design),
            'students'          => $students,
            'studentPathImage'  =>public_path('storage/student_image/'),
        		];
		$pdf = PDF::loadView('test-pdf', $data);
		return $pdf->stream('test-pdf');
    }

}
