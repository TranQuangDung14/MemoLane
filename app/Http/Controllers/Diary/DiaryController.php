<?php

namespace App\Http\Controllers\Diary;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DiaryController extends Controller
{
      //
      public function index()
      {
          # code...
          return view('Admin.pages.MyDiary.My_diary');
      }
}
