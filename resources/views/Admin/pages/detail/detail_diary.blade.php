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
                        <p><span style="color: #FF9966">{{$count_followers}}</span> người theo dõi&emsp;-&emsp; Đang theo dõi <span style="color: #FF9966">{{$count_following}}</span> người</p>
                        @if ($user->id != Auth::user()->id)

                            @if (isset($follow) && Auth::user()->id === $follow->user1_id && $user->id === $follow->user2_id)
                                {{-- @else --}}
                                <form action="{{ route('unfollow') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="id" value="{{ $follow->id }}">
                                    <input type="hidden" name="user2_id" value="{{ $user->id }}">
                                    <button type="submit" class="btn btn-success mt-2" title="Đang theo dõi"><i
                                            class="ti ti-check"></i>Đang theo dõi</button>
                                </form>
                            @else
                                <form action="{{ route('follow') }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    {{-- <input type="hidden" name="user1_id" value="{{Auth::id()}}"> --}}
                                    <input type="hidden" name="user2_id" value="{{ $user->id }}">
                                    <button type="submit" class="btn btn-primary mt-2" title="Theo dõi"><i
                                            class="ti ti-plus"></i>Theo dõi</button>
                                </form>
                            @endif
                        @endif
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

                                    @if ($value->User->avatar != '')
                                        <img src="{{ asset('storage/') }}/image/avatar/{{ $value->User->avatar }}"
                                            alt="" width="50" height="50" class="rounded-circle">
                                    @else
                                        <img src="{{ asset('Admin/') }}/images/profile/user-1.jpg" alt=""
                                            width="50" height="50" class="rounded-circle">
                                    @endif


                                    {{-- @endif --}}
                                    <div class="ms-2 mt-3">
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
                                    </div>
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
                            <div class="row mt-2">
                                {{-- <h3>{{ $value->title }}</h3>
                                @php
                                    $description = $value->description;
                                    preg_match_all('/#(\w+)/', $description, $matches);

                                    foreach ($matches[1] as $hashtag) {
                                        $url = route('diaryIndex', ['search' => $hashtag]); // Replace 'hashtag.show' with your actual route name
                                        $description = str_replace("#$hashtag", "<a href=\"$url\">#$hashtag</a>", $description);
                                    }

                                    $value->formattedDescription = $description;
                                @endphp
                                <p class="description">{!! $value->formattedDescription !!}</p> --}}
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
                                    data-post-id="{{ $value->id }}">
                                    <i class="ti ti-thumb-up fs-8"></i><span class="text-liked"> Thích</span>
                                </div>
                            {{-- @endif --}}

                            {{-- btn comment --}}
                            <div class="col-4 btn btn-outline-primary openComment" style="border: 1px solid white"
                                {{-- onclick="focusInput({{ $value->id }})"> --}} data-bs-toggle="modal"
                                {{-- data-bs-target="#exampleModal_{{ $value->id }}" data-diary-id="{{ $value->id }} --}}
                                ">
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

@endsection
