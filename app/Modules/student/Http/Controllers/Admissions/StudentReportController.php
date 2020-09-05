<?php

namespace Student\Http\Controllers\Admissions;
use App\Http\Controllers\Controller;

use Student\Models\Admissions\AdmissionReport;
use Illuminate\Http\Request;
use Student\Http\Requests\AdmissionReportRequest;

class StudentReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdmissionReportRequest  $request)
    {
        //
    }

 

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\AdmissionReport  $admissionReport
     * @return \Illuminate\Http\Response
     */
    public function edit(AdmissionReport $admissionReport)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\AdmissionReport  $admissionReport
     * @return \Illuminate\Http\Response
     */
    public function update(AdmissionReportRequest $request, AdmissionReport $admissionReport)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\AdmissionReport  $admissionReport
     * @return \Illuminate\Http\Response
     */
    public function destroy(AdmissionReport $admissionReport)
    {
        //
    }
}
