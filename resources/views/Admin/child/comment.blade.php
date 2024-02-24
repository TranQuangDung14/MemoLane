     @if (isset($value->Comments) && count($value->Comments) > 0)
     @foreach ($comments as $cmt)
             <div class="row">
                 <div class="col-md-1 d-flex align-items-center">
                     @if ($cmt->User->avatar != '')
                         <img src="{{ asset('storage/') }}/image/avatar/{{ $cmt->User->avatar }}" alt=""
                             width="60" height="60" class="rounded-circle">
                     @else
                         <img src="{{ asset('Admin/') }}/images/profile/user-1.jpg" alt="" width="60"
                             height="60" class="rounded-circle">
                     @endif

                     {{-- <?php
                     dd($follow);
                     ?> --}}
                 </div>
                 <div class="col-md-11">
                     <div class="mt-3 ms-2">
                         <p>
                             @if ($cmt->User->id === $cmt->diary->user_id)
                                 <a href="{{ route('my_diaryIndex', $cmt->User->id) }}"><span
                                         style="color:red ">{{ $cmt->User->name }} &ensp;<span
                                             style="color: #009900">(tác
                                             giả)</span> </span></a>
                                 @if ($cmt->User->id != Auth::user()->id)
                                     @if (follow($cmt->user_id) != '')
                                         @if (Auth::user()->id === follow($cmt->user_id)->user1_id && $cmt->user_id === follow($cmt->user_id)->user2_id)
                                             <span style="color: #FF9966">&nbsp;&nbsp;&nbsp;<i
                                                     class="ti ti-check"></i>Đang
                                                 theo dõi</span>
                                         @endif
                                     @endif
                                 @endif
                             @else
                                 <a href="{{ route('my_diaryIndex', $cmt->User->id) }}"><span
                                         style="color:blue ">{{ $cmt->User->name }} </span></a>
                                 @if ($cmt->User->id != Auth::user()->id)
                                     @if (follow($cmt->user_id) != '')
                                         @if (Auth::user()->id === follow($cmt->user_id)->user1_id && $cmt->user_id === follow($cmt->user_id)->user2_id)
                                             <span style="color: #FF9966">&nbsp;&nbsp;&nbsp;<i
                                                     class="ti ti-check"></i>Đang
                                                 theo dõi</span>
                                         @endif
                                     @endif
                                 @endif
                             @endif

                             &ensp;{{ \Carbon\Carbon::parse($cmt->created_at)->timezone('Asia/Ho_Chi_Minh')->format('H:i') }}&ensp;&nbsp;{{ \Carbon\Carbon::parse($cmt->created_at)->timezone('Asia/Ho_Chi_Minh')->format('d/m/Y') }}
                         </p>
                         <div class="alert alert-secondary">
                             <p>{{ $cmt->content }}</p>
                         </div>

                     </div>
                 </div>
             </div>

     @endforeach
     @else
         <center>Chưa có bình luận nào</center>
     @endif
