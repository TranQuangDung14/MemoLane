<?php

namespace App\Http\Controllers\Diary;

use App\Http\Controllers\Controller;
use App\Models\Diarys;
use App\Models\Interacts;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DiaryController extends Controller
{
    //
    public function MyDiary(Request $request,$id)
    {
        // dd(auth()->user()->id);
        // dd(Auth::user()->name);
        try {
            $userExists = User::where('id',$id)->exists();
            if($userExists){
                $diary = Diarys::with(['User' => function($query) {
                    $query->select('id', 'name','avatar','address','number_phone','sex');
                }])
                ->where('title','LIKE', '%' . $request->search . '%')->where('user_id',$id)->orderBy('id','desc')->paginate(3);
            }
            else{
                dd('ko tồn tại');
            }

            // dd($diary);
            return view('Admin.pages.MyDiary.My_diary',compact('diary'));
        } catch (\Throwable $th) {
            dd('k có');
        }

    }

    public function create()
    {
        try {
            // dd('vào');
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
            return redirect()->route('my_diaryIndex',Auth::id());
        } catch (\Exception $e) {
            dd($e);
        }
    }
    // public function like(Request $request) {
    public function like(Request $request, $id) {
        try {
            // dd('nhận');
            $like = new Interacts();
            $like->user_id = auth()->user()->id; // Lấy ID của người dùng đã đăng nhập
            $like->diary_id = $id;
            $like->save();
            return back(); // Hoặc redirect về trang bài viết
        } catch (\Throwable $th) {
            dd('sai lè');
        }
    }

    public function unlike(Request $request, $id) {
        // dd($id);
        try {
            $like = Interacts::where('user_id', auth()->user()->id)->where('diary_id', $id)->first();
            // dd($like);
            if($like) {
                $like->delete();
            }
            return back(); // Hoặc redirect về trang bài viết
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
