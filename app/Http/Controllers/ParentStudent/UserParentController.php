<?php

namespace App\Http\Controllers\ParentStudent;
use App\Http\Controllers\Controller;

class UserParentController extends Controller
{
    public function dashboard()
    {
        return view('layouts.front-end.student.index');
    }
}
