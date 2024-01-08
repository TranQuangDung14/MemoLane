@extends('Admin.layouts.master')

@section('title', 'Trang chủ')

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
                    <h5 class="mb-0 card-title fw-semibold ">{{ Auth::user()->name }}</h5>
                </div>
            </div>
        </div>
        {{-- lọc --}}
        <div class="row">
            <div class="card border">
                <div class="card-body">
                    <div class="row">

                        <div class="col-8">
                            <label>Tìm kiếm theo hastag</label>
                            <form action="{{ route('my_diaryIndex', Auth::id()) }}" method="get"
                                enctype="multipart/form-data">
                                <div class="input-group">

                                    <input class="form-control" type="text" name="search" value=""
                                        placeholder="Tìm kiếm theo hastag">
                                    <button class="btn btn-primary" type="submit"><i class="ti ti-search"></i></button>
                                </div>
                            </form>
                        </div>
                        <div class="col-4">
                            <a href="{{ route('my_diaryCreate') }}"> <button type="button"
                                    class="btn btn-primary mt-4 float-end" title="Tạo bài viết mới"><i
                                        class="ti ti-plus"></i></button></a>
                        </div>
                    </div>
                    {{-- <p class="mb-0">This is a sample page </p> --}}
                </div>
            </div>
        </div>
        @if (session('success'))
            <div class="alert alert-success" id="success-alert">
                {{ session('success') }}
                <span type="button" class="X-close float-end" data-dismiss="alert" aria-label="Close">
                    <i class="ti ti-x"></i>
                </span>
            </div>
        @elseif (session('error'))
            <div class="alert alert-danger" id="error-alert">
                {{ session('error') }}
                <span type="button" class="X-close float-end" data-dismiss="alert" aria-label="Close">
                    <i class="ti ti-x"></i>
                </span>
            </div>
        @endif
        @foreach ($diary as $key => $value)
            <div class="row d-flex align-items-stretch">
                <div class="card border">
                    <div class="card-body">


                        <div class="row">
                            <div class="col-md-3 d-flex align-items-center">
                                <img src="{{ asset('Admin/') }}/images/profile/user-1.jpg" alt="" width="50"
                                    height="50" class="rounded-circle">
                                <div class="mt-3 ms-2">
                                    <p><strong>{{ $value->User->name }}</strong>
                                        <br>
                                        <span class="text-muted fs-2">
                                            {{ \Carbon\Carbon::parse($value->created_at)->timezone('Asia/Ho_Chi_Minh')->format('H:i') }}&nbsp;&nbsp;&nbsp;&nbsp;{{ \Carbon\Carbon::parse($value->created_at)->timezone('Asia/Ho_Chi_Minh')->format('d/m/Y') }}
                                        </span>
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-9">
                                {{-- phần này thêm các chức năng sau  --}}

                            </div>
                        </div>
                        <div class="row mt-2">
                            <h3>{{ $value->title }}</h3>
                            <p class="description">{!! $value->description !!}</p>
                        </div>
                        {{-- @php
                        dd($value);
                    @endphp --}}

                    </div>
                    <hr>
                    {{-- tương tác --}}
                    <div class="row align-items-center" style="background-color: #EEEEEE">

                        @if (auth()->check() &&
                                auth()->user()->hasLiked($value))
                            <div class="col-4 btn btn-primary like-btn" style="border: 1px solid white"
                                data-post-id="{{ $value->id }}">
                                {{-- <i class="ti ti-thumb-up fs-8 icon-liked"></i> --}}
                                <i class="ti ti-thumb-up fs-8 icon-liked"></i>

                                <span class="text-liked">Bỏ thích</span>
                            </div>
                        @else
                            <div class="col-4 btn btn-outline-primary like-btn" style="border: 1px solid white"
                                data-post-id="{{ $value->id }}">
                                <i class="ti ti-thumb-up fs-8"></i><span class="text-liked"> Thích</span>
                            </div>
                        @endif


                        <div class="col-4 btn btn-outline-primary" style="border: 1px solid white"
                        {{-- onclick="focusInput({{ $value->id }})"> --}}
                        data-bs-toggle="modal" data-bs-target="#exampleModal_{{ $value->id }}">
                            <i class="ti ti-message fs-8"></i>
                        </div>
                        <div class="col-4 btn btn-outline-primary" style="border: 1px solid white">
                            <i class="ti ti-share fs-8"></i>
                        </div>
                    </div>
                    <div class="row mt-1" id="interact-section">
                        @if (isset($value->Interacts_count) &&
                                count($value->Interacts_count) > 0 &&
                                isset($value->Interacts_count[0]->interact_count) &&
                                $value->Interacts_count[0]->interact_count > 0)
                            <p>có {{ $value->Interacts_count[0]->interact_count }} người thích đoạn nhật ký này</p>
                        @else
                        @endif

                    </div>
                    {{-- <div class="row mb-3">
                        <div class="col-sm-12">
                            <form action="{{ route('commentStore') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="input-group">
                                    <input type="hidden" name="diary_id" value="{{ $value->id }}">
                                    <input class="form-control" id="focus{{ $value->id }}" type="text" name="content"
                                        value="" placeholder="Hãy nói gì đó về đoạn nhật ký này"
                                        data-bs-toggle="modal" data-bs-target="#exampleModal_{{ $value->id }}">
                                    @if ($errors->has('content'))
                                        <span class="text-danger" role="alert">{{ $errors->first('content') }}</span>
                                    @endif
                                    <button class="btn btn-primary" type="submit"><i class="ti ti-send"></i></button>
                                </div>
                            </form>
                        </div>
                    </div> --}}
                </div>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="exampleModal_{{ $value->id }}" tabindex="-1"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Danh sách bình luận nhật ký của <a
                                    href="{{ route('my_diaryIndex', $value->User->id) }}">{{ $value->User->name }}</a>
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            @if (isset($value->Comments) && count($value->Comments) > 0)
                                @foreach ($value->Comments as $cmt)
                                    {{-- <p></p> --}}
                                    <div class="row">
                                        <div class="col-md-1 d-flex align-items-center">
                                            <img src="{{ asset('Admin/') }}/images/profile/user-1.jpg" alt=""
                                                width="40" height="40" class="rounded-circle">

                                        </div>
                                        <div class="col-md-11">
                                            {{-- phần này thêm các chức năng sau  --}}
                                            <div class="mt-3 ms-2">
                                                <p><span style="color:blue ">{{ $cmt->User->name }} </span>
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
                                <p>Chưa có bình luận nào</p>
                            @endif
                            <hr>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12 d-flex align-items-center">
                                        <img src="{{ asset('Admin/') }}/images/profile/user-1.jpg" alt=""
                                            width="40" height="40" class="rounded-circle">
                                        <p class="m-2"><strong>{{ Auth::user()->name }}</strong>
                                    </div>
                                </div>
                                <div class="row mb-3 mt-2">
                                    <div class="col-sm-12">
                                        <form action="{{ route('commentStore') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="input-group">
                                                <input type="hidden" name="diary_id" value="{{ $value->id }}">
                                                <input class="form-control" id="focus{{ $value->id }}" type="text"
                                                    naƯme="content" value=""
                                                    placeholder="Hãy nói gì đó về đoạn nhật ký này">

                                                <button class="btn btn-primary" type="submit"><i
                                                        class="ti ti-send"></i></button>
                                                        <br/>
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
                        {{-- <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        </div> --}}
                    </div>
                </div>
            </div>
        @endforeach
        {{ $diary->links() }}

    </div>
    <script>
        $(document).ready(function() {
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
        });



        // focus
        //    function focusInput($id) {
        //         console.log('sss',$id);
        //        document.getElementById("focus" + $id).focus();
        //     }
    </script>
@endsection
