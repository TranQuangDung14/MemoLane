<?php

namespace App\Http\Controllers\Diary;

use App\Http\Controllers\Controller;
use App\Models\Comments;
use App\Models\Diarys;
use App\Models\Follow;
use App\Models\Interacts;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DiaryController extends Controller
{
    public function index(){
        // dd('ngừng');
        $status=[2]; // trạng thái chỉ mình tôi
        $diary = Diarys::WhereNotIn('status', $status)->get();
        // dd($diary);
        return view('Admin.pages.Diary.index',compact('diary'));
    }
    //
    public function MyDiary(Request $request,$id)
    {
        try {
            $status=[2]; // trạng thái chỉ mình tôi
            $userExists = User::where('id',$id)->exists();
            if($userExists){
                $diary = Diarys::with(['User' => function($query) {
                    $query->select('id', 'name','avatar','address','sex','number_phone');
                },
                'Interacts_count',
                'Comments' => function ($query) {
                    $query->with('user');
                    $query->orderBy('id', 'desc');
                },
                ])
                ->where('title','LIKE', '%' . $request->search . '%')
                ->where('user_id',$id)->orderBy('id','desc');
                if(Auth::user()->id != $id){
                    $diary->WhereNotIn('status', $status);
                }
                $diary = $diary->paginate(5);

            $user =user::where('id',$id)->select('id','name','avatar')->first();
            $follow =Follow::where('user1_id',Auth::user()->id)->where('user2_id',$id)->first();
            // $my_user =
            // dd($follow);
            // $user =user::with('follow')->where('id',$id)->select('id','name','avatar')->first();
                // dd(Auth()->user()->id);

            }
            else{
                dd('ko tồn tại');
            }

            // // đếm lượt like
            // $count_like=ml_interacts::where()

            // dd($diary);
            return view('Admin.pages.MyDiary.My_diary',compact('diary','user','follow'));
        } catch (\Exception $e) {
            dd($e);
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

    public function Load_Comments(Request $request)
    {
        try {
            // dd($request->diary_id);
            $comment= Comments::where('diary_id',$request->diary_id)->get();
            // dd($comment);
            // return response()->json($comment);
            $html = view('Admin.child.comment', ['comments' => $comment])->render();
            // dd($html);
            return response()->json([
                'html' => $html,
                'comment' =>$comment
            ]);
        } catch (\Exception $e) {
            dd('lỗi',$e);
        }
    }

    public function comment(Request $request)
    {
        // dd($request->all());
        $input = $request->all();

        $rules = array(
            'content'                      => 'required',
        );
        $messages = array(
            'content.required'             => '--Bình luận không được để trống!--',
        );
        $validator = Validator::make($input, $rules, $messages);

        if ($validator->fails()) {
            Toastr::error('Gửi bình luận thất bại', 'error');
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        // dd($request->all());
        DB::beginTransaction();
        try {
            // dd('nhận');
            $comment = new Comments();
            $comment->user_id = auth()->user()->id; // Lấy ID của người dùng đã đăng nhập
            $comment->diary_id = $request->diary_id;
            $comment->content = $request->content;
            $comment->save();
            DB::commit();
            // session()->flash('success', 'Cập nhật thành công!');
            // Toastr::success('Gửi bình luận thành công', 'success');
            // return redirect()->back();
            return response()->json([
                'message' =>  'Gửi bình luận thành công',
                // 'comment' =>$comment
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            return redirect()->back();
        }
    }

    public function status_diary(Request $request)
    {
        // dd('vào');
        try {
            // dd($request->all());
            $status = Diarys::find($request->id);
            $status->status = $request->status;
            $status->update();
            Toastr::success('Cập nhật trạng thái thành công', 'success');
            // return response()->json($status);
            return redirect()->back();
        } catch (\Exception $e) {
            dd($e);
            // Toastr::error('kích hoạt thất bại!', 'Failed');
            return redirect()->back();
        }
    }
    public function delete(Request $request)
    {
        try {
            $delete_diary     = Diarys::find($request->id);
            $delete_like       = Interacts::where('diary_id',$request->id)->get();
            $delete_comment    = Comments::where('diary_id',$request->id)->get();
            // dd($delete_comment);
            foreach ($delete_like as $like) {
                $like->delete();
            }
            foreach ($delete_comment as $cmt) {
                $cmt->delete();
            }
            $delete_diary->delete();
            Toastr::success('Xóa nhật ký thành công thành công', 'success');
            return redirect()->back();
        } catch (\Exception $e) {
            dd($e);
            //throw $th;
        }
    }

    public function follow(Request $request)
    {
        try {
            $follow = new Follow();
            $follow->user1_id = Auth()->user()->id; // tài khoản người đăng nhập
            $follow->user2_id = $request->user_id; // tài khoản chọn để theo dõi
            $follow->save();
            $user = User::select('id','name')->where('id',$request->id)->first();
            Toastr::success('Bạn đang theo dõi'.$user->name, 'success');
            return redirect()->back();
        } catch (\Exception $e) {
            //throw $th;
        }
    }

    public function unfollow(Request $request)
    {
        try {
            $unfollow = Follow::find($request->id);
            $unfollow->delete();
            $user = User::select('id','name')->where('id',$request->id)->first();
            Toastr::success('Bạn đã hủy theo dõi'.$user->name, 'success');
            return redirect()->back();
        } catch (\Exception $e) {
            //throw $th;
        }
    }
}
