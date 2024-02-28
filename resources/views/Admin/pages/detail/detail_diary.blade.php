@extends('Admin.layouts.master')

@section('title', 'Trang cá nhân')

@section('content')
    <style>
        /* Áp dụng kiểu cho hình ảnh trong trường mô tả */
        p img {
            max-width: 100%;
            /* Đặt chiều rộng tối đa cho ảnh */
            height: auto;
            /* Tự động tính chiều cao dựa trên chiều rộng */
        }

        .text-liked {
            position: relative;
            top: -2px;
        }
    </style>

    <div class="container-fluid ">
        {{-- tiêu đề trang --}}
        <div class="row ">
            <div class="card border">
                <div class="card-body">
                    {{-- <h5 class="card-title fw-semibold mb-4">Danh mục sản phẩm</h5> --}}
                    <center>

                        @if ($user->avatar != '')
                            <img src="{{ asset('storage/') }}/image/avatar/{{ $user->avatar }}" alt="" width="100"
                                height="100" class="rounded-circle">
                        @else
                            <img src="{{ asset('Admin/') }}/images/profile/user-1.jpg" alt="" width="100"
                                height="100" class="rounded-circle">
                        @endif
                        <h5 class=" card-title fw-semibold mt-2">{{ $user->name }}</h5>

                    </center>
                </div>
            </div>
        </div>
        {{-- @if ($diary->count() > 0) --}}
            {{-- @foreach ($diary as $key => $value) --}}
                <div class="row d-flex align-items-stretch">
                    <div class="card border">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 d-flex align-items-center">

                                    @if ($user->avatar != '')
                                        <img src="{{ asset('storage/') }}/image/avatar/{{ $user->avatar }}"
                                            alt="" width="50" height="50" class="rounded-circle">
                                    @else
                                        <img src="{{ asset('Admin/') }}/images/profile/user-1.jpg" alt=""
                                            width="50" height="50" class="rounded-circle">
                                    @endif


                                    {{-- @endif --}}
                                    {{-- <div class="ms-2 mt-3">
                                        <p><strong>{{ $value->User->name }}</strong>
                                            @if ($user->id != Auth::user()->id)
                                                @if (isset($follow) && Auth::user()->id === $follow->user1_id && $user->id === $follow->user2_id)
                                                    <span style="color: #FF9966">&nbsp;&nbsp;&nbsp;<i
                                                            class="ti ti-check"></i>Đang theo dõi</span>
                                                @endif
                                            @endif
                                            <br>

                                            <span class="text-muted fs-2">
                                                {{ \Carbon\Carbon::parse($value->created_at)->timezone('Asia/Ho_Chi_Minh')->format('H:i') }}&nbsp;&nbsp;&nbsp;&nbsp;{{ \Carbon\Carbon::parse($value->created_at)->timezone('Asia/Ho_Chi_Minh')->format('d/m/Y') }}
                                            </span> &nbsp;
                                            @if ($value->User->id === Auth::id())
                                                <span style="color: #FF9966">
                                                    @if ($value->status == 1)
                                                        <i class="ti ti-world"></i> Công khai
                                                    @elseif ($value->status == 2)
                                                        <i class="ti ti-user"></i> mình tôi
                                                    @elseif ($value->status == 3)
                                                        <i class="ti ti-user-plus"></i> chỉ người theo dõi
                                                    @endif
                                                </span>
                                            @endif

                                        </p>
                                    </div> --}}
                                </div>
                                <div class="col-md-8">
                                    {{-- phần này thêm các chức năng sau  --}}
                                    {{-- @if (Auth::user()->id === $value->user->id)
                                        <div class="dropdown">

                                            <i id="dropdownMenuButton" data-bs-toggle="dropdown"
                                                class="ti ti-dots float-end fs-6" style="cursor: pointer;"></i>

                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <li><a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                        data-bs-target="#ModalStatus_{{ $value->id }}">Chỉnh trạng thái
                                                        nhật
                                                        ký</a></li>
                                                <li><a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                        data-bs-target="#ModalDelete_{{ $value->id }}">Xóa bài nhật
                                                        ký</a>
                                                </li>
                                            </ul>
                                        </div>
                                    @else
                                    @endif --}}
                                </div>
                            </div>
                            <div class="row mt-2 ">
                                <h3>{{ $detail->title }}</h3>
                                @php
                                    $description = $detail->description;
                                    preg_match_all('/#(\w+)/', $description, $matches);

                                    foreach ($matches[1] as $hashtag) {
                                        $url = route('diaryIndex', ['search' => $hashtag]); // Replace 'hashtag.show' with your actual route name
                                        $description = str_replace("#$hashtag", "<a href=\"$url\">#$hashtag</a>", $description);
                                    }

                                    $detail->formattedDescription = $description;
                                @endphp
                                <p class="description">{!! $detail->formattedDescription !!}</p>
                            </div>


                        </div>
                        <hr>
                        {{-- tương tác --}}
                        <div class="row align-items-center" style="background-color: #EEEEEE">

                            {{-- @if (auth()->check() && auth()->user()->hasLiked($value))
                                <div class="col-4 btn btn-primary like-btn" style="border: 1px solid white"
                                    data-post-id="{{ $value->id }}">

                                    <i class="ti ti-thumb-up fs-8 icon-liked"></i>

                                    <span class="text-liked">Bỏ thích</span>
                                </div>
                            @else --}}
                                <div class="col-4 btn btn-outline-primary like-btn" style="border: 1px solid white"
                                    {{-- data-post-id="{{ $value->id }}" --}}
                                    >
                                    <i class="ti ti-thumb-up fs-8"></i><span class="text-liked"> Thích</span>
                                </div>
                            {{-- @endif --}}

                            {{-- btn comment --}}
                            <div class="col-4 btn btn-outline-primary openComment" style="border: 1px solid white"
                                {{-- onclick="focusInput({{ $value->id }})"> --}} data-bs-toggle="modal"
                                {{-- data-bs-target="#exampleModal_{{ $value->id }}" data-diary-id="{{ $value->id }} "--}}
                                >
                                <i class="ti ti-message fs-8"></i>
                            </div>
                            <div class="col-4 btn btn-outline-primary" style="border: 1px solid white">
                                <i class="ti ti-share fs-8"></i>
                            </div>
                        </div>
                        <div class="row mt-1" id="interact-section">
                            {{-- @if (isset($value->Interacts_count) &&
                                    count($value->Interacts_count) > 0 &&
                                    isset($value->Interacts_count[0]->interact_count) &&
                                    $value->Interacts_count[0]->interact_count > 0)
                                <p>có {{ $value->Interacts_count[0]->interact_count }} người thích đoạn nhật ký này</p>
                            @else
                            @endif --}}

                        </div>
                        <div class="row mt-1" id="interact-section">
                            @foreach ($detail->Comments as $cmt)
                            <div class="row">
                                <div class="col-md-1 d-flex align-items-center">
                                    {{-- @if ($cmt->User->avatar != '')
                                        <img src="{{ asset('storage/') }}/image/avatar/{{ $cmt->User->avatar }}" alt="" width="60"
                                            height="60" class="rounded-circle">
                                    @else --}}
                                        <img src="{{ asset('Admin/') }}/images/profile/user-1.jpg" alt="" width="60" height="60"
                                            class="rounded-circle">
                                    {{-- @endif --}}


                                </div>
                                <div class="col-md-11">
                                    <div class="mt-3 ms-2">
                                        <p>
                                            @if ($cmt->User->id === $cmt->diary->user_id)
                                                <a href="{{ route('my_diaryIndex', $cmt->User->id) }}"><span
                                                        style="color:red ">{{ $cmt->User->name }} &ensp;<span style="color: #009900">(tác
                                                            giả)</span> </span></a>
                                                @if ($cmt->User->id != Auth::user()->id)
                                                    @if (follow($cmt->user_id) != '')
                                                        @if (Auth::user()->id === follow($cmt->user_id)->user1_id && $cmt->user_id === follow($cmt->user_id)->user2_id)
                                                            <span style="color: #FF9966">&nbsp;&nbsp;&nbsp;<i class="ti ti-check"></i>Đang
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
                                                            <span style="color: #FF9966">&nbsp;&nbsp;&nbsp;<i class="ti ti-check"></i>Đang
                                                                theo dõi</span>
                                                        @endif
                                                    @endif
                                                @endif
                                            @endif

                                            &ensp;{{ \Carbon\Carbon::parse($cmt->created_at)->timezone('Asia/Ho_Chi_Minh')->format('H:i') }}&ensp;&nbsp;{{ \Carbon\Carbon::parse($cmt->created_at)->timezone('Asia/Ho_Chi_Minh')->format('d/m/Y') }}
                                        </p>
                                        <div class="alert alert-secondary">
                                            <p>{{ $cmt->content }}</p>
                                            {{-- <p>cmt->content </p> --}}
                                        </div>

                                    </div>
                                </div>
                            </div>

                        @endforeach

                        </div>
                        <div class="row mb-3 mt-2">
                            <div class="col-sm-12">
                                <form class="addCommentForm" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    {{-- <input class="form-control diary-id-input" id="focus{{ $value->id }}" type="text" name="content" value="" placeholder="Hãy nói gì đó về đoạn nhật ký này"> --}}
                                    <div class="input-group">
                                        <input type="hidden" class="diary-id-input" name="diary_id"
                                            {{-- value="{{ $value->id }}" --}}
                                            >
                                        <input class="form-control"
                                        {{-- id="focus{{ $value->id }}" --}}
                                            type="text" name="content" value=""
                                            placeholder="Hãy nói gì đó về đoạn nhật ký này">
                                        <button class="btn btn-primary submitCommentBtn" type="submit"><i
                                                class="ti ti-send"></i></button>
                                        <br />
                                    </div>
                                </form>
                            </div>
                            <div class="col-sm-12">
                                @if ($errors->has('content'))
                                    <span class="text-danger" role="alert">{{ $errors->first('content') }}</span>
                                @endif
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Modal comment-->
                {{-- <div class="modal fade" id="exampleModal_{{ $value->id }}" tabindex="-1"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Danh sách bình luận nhật ký của <a
                                        href="{{ route('my_diaryIndex', $value->User->id) }}">{{ $value->User->name }}
                                        {{ $value->id }}</a>
                                </h5>
                                <span class="ms-5"><button class="loadcmt btn btn-outline-secondary"
                                        data-diary-id="{{ $value->id }}">Tải lại bình luận</button></span>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>

                            <div class="modal-body commentsContainer" style="max-height: 60vh; overflow-y: auto;">

                            </div>

                            <div class="modal-footer">
                                <div class="container">
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-12 d-flex align-items-center">
                                            @if (Auth::user()->avatar != '')
                                                <img src="{{ asset('storage/') }}/image/avatar/{{ Auth::user()->avatar }}"
                                                    alt="" width="40" height="40" class="rounded-circle">
                                            @else
                                                <img src="{{ asset('Admin/') }}/images/profile/user-1.jpg" alt=""
                                                    width="40" height="40" class="rounded-circle">
                                            @endif
                                            <p class="m-2"><strong>{{ Auth::user()->name }}</strong>
                                        </div>
                                    </div>
                                    <div class="row mb-3 mt-2">
                                        <div class="col-sm-12">
                                            <form class="addCommentForm" enctype="multipart/form-data">
                                                {{ csrf_field() }}
                                                <div class="input-group">
                                                    <input type="hidden" class="diary-id-input" name="diary_id"
                                                        value="{{ $value->id }}">
                                                    <input class="form-control" id="focus{{ $value->id }}"
                                                        type="text" name="content" value=""
                                                        placeholder="Hãy nói gì đó về đoạn nhật ký này">
                                                    <button class="btn btn-primary submitCommentBtn" type="button"><i
                                                            class="ti ti-send"></i></button>
                                                    <br />
                                                </div>
                                            </form>
                                        </div>
                                        <div class="col-sm-12">
                                            @if ($errors->has('content'))
                                                <span class="text-danger"
                                                    role="alert">{{ $errors->first('content') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}
                <!-- Modal status -->
                {{-- <div class="modal fade" id="ModalStatus_{{ $value->id }}" tabindex="-1"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <form action="{{ route('diaryStatus') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="id" value="{{ $value->id }}">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Chỉnh trạng thái nhật ký</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <select name="status" id="" class="form-select">
                                        <option value="1" {{ $value->status === 1 ? 'selected' : '' }}> <span>Công
                                                khai</option>
                                        <option value="2" {{ $value->status === 2 ? 'selected' : '' }}>Chỉ mình tôi
                                        </option>
                                        <option value="3" {{ $value->status === 3 ? 'selected' : '' }}>Chỉ người theo
                                            dõi</option>
                                    </select>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                    <button type="submit" class="btn btn-primary">Xác nhận</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div> --}}
                <!-- Modal delete -->
                {{-- <div class="modal fade" id="ModalDelete_{{ $value->id }}" tabindex="-1"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Xóa</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Bạn có chắc muốn xóa sản phẩm này không ?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                <form action="{{ route('My_diaryDelete') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="id" value="{{ $value->id }}">
                                    <button type="submit" class="btn btn-primary">Xóa</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div> --}}
            {{-- @endforeach --}}
            {{-- {{ $diary->links() }} --}}
        {{-- @else
            @if (Auth::user()->id == $user->id)
                <center>Bạn chưa có chia sẻ nhật kí! hãy chia sẻ đi</center>
            @else
                <center> {{ $user->name }} chưa có bài viết nào cả!</center>
            @endif
        @endif --}}


    </div>
<script>
            $(document).ready(function() {
            loadComments();
            // ReloadComments();
            // addComment();

            //  submit khi nhấn enter
            $('.addCommentForm').on('submit', function(e) {
                e.preventDefault(); // Ngăn chặn hành vi mặc định của form
                var form = $(this);
                var diaryId = form.find(".diary-id-input").val();
                addComment(diaryId, form);
                // Xóa nội dung trong input sau khi gửi
                form.find('.form-control').val('');
            });

            $('.loadcmt').on('click', function() {
                var diary_id = $(this).data('diary-id');
                console.log('loadcmt', diary_id)
                ReloadComments(diary_id)
            });

            // submit khi click nút gửi
            $('.submitCommentBtn').on('click', function() {
                // $(document).on('click', '.submitCommentBtn', function() {
                // var diaryId = $(".diary-id-input").val();
                // var form = $(this).closest('form');

                var form = $(this).closest('form');
                // console.log('vào rồi', form);
                var diaryId = form.find(".diary-id-input").val();
                // console.log('vào rồi id', diaryId);
                // addComment(diaryId);
                addComment(diaryId, form);

                // Xóa nội dung trong input sau khi gửi
                form.find('.form-control').val('');
            });

            function addComment(diary_id, form) {
                // console.log('ssss', diary_id);
                $.ajax({
                    url: '{{ route('commentStore') }}',
                    type: 'POST',
                    // data: form.serialize(),
                    data: form.serialize(),
                    // data: $('#addCommentForm').serialize(),
                    success: function(response) {

                        console.log('id nhật ký', response);
                        ReloadComments(diary_id)
                        setTimeout(function() {
                            toastr.success(
                                response.message,
                                // "Success Alert", {
                                //     iconClass: "customer-info",
                                // }, {
                                //     timeOut: 2000,
                                // }
                            );
                        }, 500);
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
                // });

            }
            $('.like-btn').on('click', function(e) {
                e.preventDefault();
                var postId = $(this).data('post-id');
                var token = "{{ csrf_token() }}";
                var isLiked = $(this).find('.text-liked').text().trim() === 'Bỏ thích';
                if (isLiked) {
                    $(this).removeClass('btn-primary').addClass('btn-outline-primary');
                } else {
                    $(this).removeClass('btn-outline-primary').addClass('btn-primary');
                }
                $.ajax({
                    type: 'POST',
                    url: isLiked ? '{{ route('diaryUnlike', '') }}/' + postId :
                        '{{ route('diaryLike', '') }}/' + postId,
                    data: {
                        '_token': token,
                    },
                    success: function(data) {
                        console.log('data', data);

                        var likeBtn = $('.like-btn[data-post-id=' + postId + ']');
                        if (isLiked) {
                            likeBtn.find('i').removeClass('icon-liked');
                            likeBtn.find('.text-liked').text('Thích');
                        } else {
                            likeBtn.find('i').addClass('icon-liked');
                            likeBtn.find('.text-liked').text('Bỏ thích');
                        }
                        location.reload(); // tạm thời để như vầy sau tìm cách khắc phục :))
                    },
                    error: function(err) {
                        console.error('lỗi', err);
                    }
                });
            });



            // tải comment khi bật comment
            function loadComments() {
                // Đặt sự kiện click cho nút mở comment
                $('.openComment').click(function() {
                    var clickedDiaryId = $(this).data('diary-id');
                    console.log('ádad', clickedDiaryId);
                    $.ajax({
                        url: '{{ route('commentLoad') }}',
                        type: 'GET',
                        data: {
                            diary_id: clickedDiaryId
                        },
                        success: function(data) {
                            $('#exampleModal_' + clickedDiaryId + ' .modal-body').html(data
                                .html);
                            // console.log('data nè', data.html);
                        },
                        error: function(error) {
                            console.log(error);
                        }
                    });
                });
            }

            // xử lý load lại khi có thao tác gọi đến
            function ReloadComments(diary_id) {
                // console.log('Id hàm nhật ký nhận', diary_id);
                var clickedDiaryId = diary_id;
                $.ajax({
                    url: '{{ route('commentLoad') }}',
                    type: 'GET',
                    data: {
                        diary_id: clickedDiaryId
                    },
                    success: function(data) {
                        $('#exampleModal_' + clickedDiaryId + ' .modal-body').html(data.html);
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            }


        });
</script>
@endsection
