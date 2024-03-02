<?php

namespace App\Http\Controllers\Diary;

use App\Events\NotificationPusher;
use App\Http\Controllers\Controller;
use App\Models\Comments;
use App\Models\Diarys;
use App\Models\Follow;
use App\Models\Hashtags;
use App\Models\Interacts;
use App\Models\Notifications;
use App\Models\RLTS_Diary_hastag;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DiaryController extends Controller
{
    // trang chủ
    public function index(Request $request)
    {
        // dd('ngừng');
        $status = [2]; // trạng thái chỉ mình tôi
        $hashtag = null;
        if ($request->has('search') && $request->search !== null) {
            // $hashtag = Hashtags::where('name', 'LIKE', '%' . $request->search . '%')->first()->id;
            $hashtag = Hashtags::where('name', '=', $request->search)->first();
            // dd($hashtag);
            if ($hashtag == null) {
                // dd('k có');
                $diary = Diarys::where('id', 0)->get();
                return view('Admin.pages.Diary.index', compact('diary'));
            }
        }
        $diary = Diarys::orderBy('created_at')->inRandomOrder()->WhereNotIn('status', $status);
        if ($hashtag != null) {
            $diary->whereHas('relationship_hastag', function ($query) use ($hashtag) {
                $query->where('hashtag_id', $hashtag->id);
            });
        }
        $diary = $diary->get();

        return view('Admin.pages.Diary.index', compact('diary'));
    }

    // trang cá nhân
    public function MyDiary(Request $request, $id)
    {
        try {
            // dd($id);
            $status = [2]; // trạng thái chỉ mình tôi
            $hashtag = null;
            $user = user::where('id', $id)->select('id', 'name', 'avatar')->first();
            $follow = Follow::query();
            $count_followers_query = clone $follow;
            $count_followeing_query = clone $follow;

            // if (Auth::user()->id ===  $id) {
            //     //  người theo dõi
            //     $count_followers = $count_followers_query->where('user2_id', Auth::user()->id)->count();
            //     // đang theo dõi
            //     $count_following = $count_followeing_query->where('user1_id', Auth::user()->id)->count();
            // } else {
            //  người theo dõi
            $count_followers = $count_followers_query->where('user2_id', $id)->count();
            // đang theo dõi
            $count_following = $count_followeing_query->where('user1_id', $id)->count();
            // }

            // dd($count_follow);
            $follow = $follow->where('user1_id', Auth::user()->id)->where('user2_id', $id)->first();

            // $relationship = null;
            // dd($follow);
            if ($request->has('search') && $request->search !== null) {
                // $hashtag = Hashtags::where('name', 'LIKE', '%' . $request->search . '%')->first()->id;
                $hashtag = Hashtags::where('name', '=', $request->search)->first();
                // dd($hashtag);
                if ($hashtag == null) {
                    // dd('k có');
                    $diary = Diarys::where('id', 0)->get();
                    return view('Admin.pages.MyDiary.My_diary', compact('diary', 'user', 'follow', 'count_followers', 'count_following'));
                }
            }
            $userExists = User::where('id', $id)->exists();
            if ($userExists) {
                $diary = Diarys::with([
                    'User' => function ($query) {
                        $query->select('id', 'name', 'avatar', 'address', 'sex', 'number_phone');
                    },
                    'Interacts_count',
                    'Comments' => function ($query) {
                        $query->with('user');
                        $query->orderBy('id', 'desc');
                    },
                    'relationship_hastag'

                ])
                    ->where('user_id', $id)->orderBy('id', 'desc');

                // ->where('diary_hashtags.hashtag_id',$hashtag)
                if ($hashtag != null) {
                    $diary->whereHas('relationship_hastag', function ($query) use ($hashtag) {
                        $query->where('hashtag_id', $hashtag->id);
                    });
                }

                if (Auth::user()->id != $id) {
                    $diary->WhereNotIn('status', $status);
                }
                $diary = $diary->paginate(5);
                // dd($diary);

            } else {
                dd('ko tồn tại');
            }
            return view('Admin.pages.MyDiary.My_diary', compact('diary', 'user', 'follow', 'count_followers', 'count_following'));
        } catch (\Exception $e) {
            dd($e);
        }
    }

    // mở trang tạo mới
    public function create()
    {
        try {
            // dd('vào');
            return view('Admin.pages.MyDiary.Create');
        } catch (\Exception $e) {
            dd($e);
        }
    }
    // xử lý tạo mới
    public function store(Request $request)
    {
        try {
            $input = $request->all();

            $rules = array(
                'title'                             => 'required',
                'description'                       => 'required',
            );
            $messages = array(
                'title.required'                    => '--Tiêu đề không được để trống!--',
                'description.required'              => '--Nội dung không được để trống!--',
            );
            $validator = Validator::make($input, $rules, $messages);

            if ($validator->fails()) {
                Toastr::error('Tạo bài viết nhật ký thất bại', 'error');
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            $table  = new Diarys();
            $table->title = $request->title;
            $table->description = $request->description;
            // $table->hashtags = $request->hashtags;
            $table->user_id = Auth::id();
            $table->save();

            preg_match_all('/#(\w+)/', $request->description, $matches);

            $hashtags = $matches[1];
            foreach ($hashtags as $tag) {
                $hashtagExists = Hashtags::where('name', $tag)->exists();
                if ($hashtagExists) {
                    $hashtag = Hashtags::where('name', $tag)->first();
                } else {
                    $hashtag = new Hashtags();
                    $hashtag->name = $tag;
                    $hashtag->save();
                }

                $rlt_hashtag_diary = new RLTS_Diary_hastag();
                $rlt_hashtag_diary->diary_id = $table->id;
                $rlt_hashtag_diary->hashtag_id = $hashtag->id;
                $rlt_hashtag_diary->save();
            }
            Toastr::success('Tạo bài viết thành công', 'success');
            return redirect()->route('my_diaryIndex', Auth::id());
        } catch (\Exception $e) {
            dd($e);
        }
    }
    //thích bài viết
    public function like(Request $request, $id)
    {
        try {
            // dd('nhận');
            $like = new Interacts();
            $like->user_id = auth()->user()->id; // Lấy ID của người dùng đã đăng nhập
            $like->diary_id = $id;
            $like->save();

            $diary = Diarys::where('id', $id)->first();
            // $diary = Diarys::first($id);
            // dd($diary);
            if ($diary->user_id != auth()->user()->id) {
                $notification = new Notifications();
                $notification->user1_id = auth()->user()->id;
                $notification->user2_id = $diary->user_id;
                $notification->diary_id = $id;
                $notification->event_id = $like->id;
                $notification->type = 0;
                $notification->save();
                event(new NotificationPusher('notification'));
            }
            return back(); // Hoặc redirect về trang bài viết
        } catch (\Exception $e) {
            dd($e);
        }
    }
    // bỏ thích bài viết
    public function unlike(Request $request, $id)
    {
        // dd($id);
        try {

            $like = Interacts::where('user_id', auth()->user()->id)->where('diary_id', $id)->first();
            // $like = Interacts::where('user_id', auth()->user()->id)->where('diary_id', $id)->get();
            // dd($notification);
            if ($like) {
                // dd($like);
                $notification = Notifications::where('event_id', $like->id)->where('user1_id', Auth()->user()->id)->first();
                $like->delete();
                if ($notification != null) {
                    $notification->delete();
                }
            }
            event(new NotificationPusher('notification'));
            return back(); // Hoặc redirect về trang bài viết
        } catch (\Exception $e) {
            //throw $th;
            dd($e);
        }
    }

    // tải bình luận theo bài viết
    public function Load_Comments(Request $request)
    {
        try {
            $comment = Comments::where('diary_id', $request->diary_id)->get();
            $html = view('Admin.child.comment', [
                'comments' => $comment,
                // 'follow'   =>$follow
            ])->render();
            // dd($html);
            return response()->json([
                'html' => $html,
                'comment' => $comment
            ]);
        } catch (\Exception $e) {
            dd('lỗi', $e);
        }
    }
    // Tạo bình luận thuần
    public function comment_pure(Request $request)
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
            // dd($request->all());
            // dd('nhận');
            $comment = new Comments();
            $comment->user_id = auth()->user()->id; // Lấy ID của người dùng đã đăng nhập
            $comment->diary_id = $request->diary_id;
            $comment->content = $request->content;
            $comment->save();

            $diary = Diarys::where('id', $request->diary_id)->first();

            if ($diary->user_id != auth()->user()->id) {
                $notification = new Notifications();
                $notification->user1_id = auth()->user()->id;
                $notification->user2_id = $diary->user_id;
                $notification->diary_id = $request->diary_id;
                $notification->event_id = $comment->id;
                $notification->type = 2;
                $notification->save();
                event(new NotificationPusher('notification'));
            }

            DB::commit();
            // session()->flash('success', 'Cập nhật thành công!');
            Toastr::success('Gửi bình luận thành công', 'success');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            return redirect()->back();
        }
    }
    // Tạo bình luận cho ajax
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
            // dd($request->all());
            // dd('nhận');
            $comment = new Comments();
            $comment->user_id = auth()->user()->id; // Lấy ID của người dùng đã đăng nhập
            $comment->diary_id = $request->diary_id;
            $comment->content = $request->content;
            $comment->save();

            $diary = Diarys::where('id', $request->diary_id)->first();

            if ($diary->user_id != auth()->user()->id) {
                $notification = new Notifications();
                $notification->user1_id = auth()->user()->id;
                $notification->user2_id = $diary->user_id;
                $notification->diary_id = $request->diary_id;
                $notification->event_id = $comment->id;
                $notification->type = 2;
                $notification->save();
                event(new NotificationPusher('notification'));
            }

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

   // xóa bình luận
   public function delete_comment(Request $request)
   {
       try {
           $delete_comment = Comments::where('id', $request->id)->first();
        //    dd($delete_comment);
           $notification = Notifications::where('event_id',  $request->id)->first();
        //    dd($notification);
           if ($delete_comment) {
               $delete_comment->delete();
               if ($notification != null) {
                   $notification->delete();
               }
           }
           event(new NotificationPusher('notification'));
           return back(); // Hoặc redirect về trang bài viết
       } catch (\Exception $e) {
           //throw $th;
           dd($e);
       }
   }

    //  kích hoạt trạng thái nhật ký
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
    //  xóa nhật ký
    public function delete(Request $request)
    {
        try {
            $delete_diary           = Diarys::find($request->id);
            $delete_like            = Interacts::where('diary_id', $request->id)->get();
            $delete_comment         = Comments::where('diary_id', $request->id)->get();
            $delete_notification    = Notifications::where('diary_id', $request->id)->get();
            // dd($delete_comment);
            foreach ($delete_like as $like) {
                $like->delete();
            }
            foreach ($delete_comment as $cmt) {
                // dd($cmt);
                $cmt->delete();
            }
            foreach ($delete_notification as $noti) {
                $noti->delete();
            }
            $delete_diary->delete();
            Toastr::success('Xóa nhật ký thành công thành công', 'success');
            return redirect()->back();
        } catch (\Exception $e) {
            dd($e);
            //throw $th;
        }
    }
    // Theo dõi người dùng
    public function follow(Request $request)
    {
        // dd($request->all());
        try {
            $follow = new Follow();
            $follow->user1_id = Auth()->user()->id; // tài khoản người đăng nhập
            $follow->user2_id = $request->user2_id; // tài khoản chọn để theo dõi
            $follow->save();
            // $diary = Diarys::first($id);
            // dd($diary);
            // if ($diary->user_id != auth()->user()->id) {
            $notification = new Notifications();
            $notification->user1_id = auth()->user()->id;
            $notification->user2_id = $request->user2_id;
            // $notification->diary_id = $id;
            $notification->event_id = $follow->id;
            $notification->type = 1;
            $notification->save();
            // }
            event(new NotificationPusher('notification'));
            $user = User::select('id', 'name')->where('id', $request->user2_id)->first();
            Toastr::success('Bạn đang theo dõi ' . $user->name, 'success');
            return redirect()->back();
        } catch (\Exception $e) {
            //throw $th;
        }
    }
    // hủy theo dõi người dùng
    public function unfollow(Request $request)
    {
        try {
            $unfollow = Follow::find($request->id);
            $notification = Notifications::where('event_id', $unfollow->id)->where('user1_id', Auth()->user()->id)->first();
            if ($notification != null) {
                $notification->delete();
            }
            $unfollow->delete();
            event(new NotificationPusher('notification'));
            $user = User::select('id', 'name')->where('id', $request->user2_id)->first();
            Toastr::success('Bạn đã hủy theo dõi ' . $user->name, 'success');
            return redirect()->back();
        } catch (\Exception $e) {
            //throw $th;
        }
    }

    public function notification()
    {
        try {
            $noti = Notifications::with('diary')->where('user2_id', Auth::user()->id)->orderBy('id', 'DESC')->get();
            $html = view('Admin.child.notification', [
                'notification' => $noti,
            ])->render();
            return response()->json([
                'html' => $html,
                'notification' => $noti
            ]);
        } catch (\Exception $e) {
            dd('lỗi', $e);
        }
    }

    public function detail_diary($user_id, $id)
    {
        // dd($user_id,$id);
        try {
            $detail = Diarys::with([

                'Comments' => function ($query) {
                    $query->orderBy('id', 'DESC');
                },
            ])->findOrFail($id);
            // dd($detail);
            $user = User::findOrFail($user_id);
            // dd($user->avatar);
            return view('Admin.pages.detail.detail_diary', compact('detail', 'user'));
        } catch (\Exception $e) {
            dd($e);
            //throw $th;
        }
    }

    public function Showfollow($id)
    {
        try {
            $follow = Follow::query();

            $count_followers_query = clone $follow;
            $count_followeing_query = clone $follow;
            //  người theo dõi
            $count_followers = $count_followers_query->where('user2_id', $id)->get();
            // đang theo dõi
            $count_following = $count_followeing_query->where('user1_id', $id)->get();

            $user = User::find($id);
            return view('Admin.follow.follow', compact('count_followers', 'count_following', 'user'));
        } catch (\Exception $e) {
        }
    }
}
