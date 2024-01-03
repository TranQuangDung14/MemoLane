<?php

namespace App\Http\Controllers\Diary;

use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class Testcontroller extends Controller
{
    //
    public function index()
    {
        // Toastr::success('Your message here', 'Title');
        # code...
        return view('Admin.pages.test.test');
    }
}
