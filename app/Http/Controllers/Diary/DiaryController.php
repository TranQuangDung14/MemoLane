<?php

namespace App\Http\Controllers\Diary;

use App\Http\Controllers\Controller;
use App\Models\Diarys;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DiaryController extends Controller
{
    //
    public function index(Request $request)
    {
        // dd(Auth::user()->name);
        $diary = Diarys::where('title','LIKE', '%' . $request->search . '%')->orderBy('id','desc')->paginate(2);
        return view('Admin.pages.MyDiary.My_diary',compact('diary'));
    }

    public function create()
    {
        try {
            return view('Admin.pages.MyDiary.Create');
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function store(Request $request)
    {
        try {
            $table  = new Diarys();
            $table->title = $request->title;
            $table->description = $request->description;
            // $table->hashtags = $request->hashtags;
            $table->user_id = Auth::id();
            $table->save();
            Toastr::success('Tạo bài viết thành công', 'success');
            return redirect()->route('my_diaryIndex');
        } catch (\Exception $e) {
            dd($e);
        }
    }
}
