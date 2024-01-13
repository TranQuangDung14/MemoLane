     {{-- @if (isset($value->Comments) && count($value->Comments) > 0) --}}
         @foreach ($comments as $cmt)
             <div class="row">
                 <div class="col-md-1 d-flex align-items-center">
                     <img src="{{ asset('Admin/') }}/images/profile/user-1.jpg" alt="" width="40" height="40"
                         class="rounded-circle">

                 </div>
                 <div class="col-md-11">
                     <div class="mt-3 ms-2">
                         <p>
                             {{-- @if ($cmt->User->id === $value->User->id) --}}
                                 <a href="{{ route('my_diaryIndex', $cmt->User->id) }}"><span
                                         style="color:red ">{{ $cmt->User->name }} &ensp;<span
                                             style="color: #009900">tác giả</span> </span></a>
                             {{-- @else
                                 <a href="{{ route('my_diaryIndex', $cmt->User->id) }}"><span
                                         style="color:blue ">{{ $cmt->User->name }} </span></a>
                             @endif --}}

                             &ensp;{{ \Carbon\Carbon::parse($cmt->created_at)->timezone('Asia/Ho_Chi_Minh')->format('H:i') }}&ensp;&nbsp;{{ \Carbon\Carbon::parse($cmt->created_at)->timezone('Asia/Ho_Chi_Minh')->format('d/m/Y') }}
                         </p>
                         <div class="alert alert-secondary">
                             <p>{{ $cmt->content }}</p>
                         </div>

                     </div>
                 </div>
             </div>
         @endforeach
     {{-- @else
         <p>Chưa có bình luận nào</p>
     @endif --}}
