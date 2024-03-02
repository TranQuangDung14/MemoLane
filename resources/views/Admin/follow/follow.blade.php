@extends('Admin.layouts.master')

@section('title', 'Tìm kiếm người dùng')

@section('content')
    <style>
        @media (max-width: 576px) {

            /* Hiển thị cho màn hình nhỏ hơn hoặc bằng 576px */
            .border-end-sm {
                /* Tạo một lớp mới */
                border-right: none !important;
                /* Ẩn border-end */
            }
        }
    </style>
    <div class="container-fluid ">
        {{-- tiêu đề trang --}}
        {{-- <div class="row ">
        <div class="card border">
            <div class="card-body">
                <h5 class="mb-0 card-title fw-semibold ">Danh mục sản phẩm </h5>
            </div>
        </div>
    </div> --}}
        {{-- lọc --}}
        <div class="row">
            <div class="card border">
                <div class="card-body">
                    <div class="row">

                        <div class="col-8">
                            <h5>THÔNG TIN THEO DÕI</h5>
                            {{-- <label>Thông tin follow</label> --}}
                            {{-- <div class="input-group">

                                <input class="form-control" type="text" name="search" value=""
                                    placeholder="nhập tên danh mục">
                                <button class="btn btn-primary" type="submit"><i class="ti ti-search"></i></button>
                            </div> --}}
                        </div>
                        <div class="col-4">
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
                        <p><span style="color: #FF9966">{{$count_followers->count()}}</span> người theo dõi&emsp;-&emsp; Đang theo dõi <span style="color: #FF9966">{{$count_following->count()}}</span> người</p>

                    </center>
                </div>
            </div>
        </div>
        <div class="row d-flex align-items-stretch">
            <div class="card border">
                <div class="card-body p-4">

                    <div class="row">
                        <div class="col-sm-6 border-end border-success border-end-sm">
                            <p class="border-bottom text-center">Có  <span style="color: #FF9966">{{$count_followers->count()}}</span> người theo dõi</p>
                            @foreach ($count_followers as $value)
                            <div class="row mt-1">
                                <a href="{{ route('my_diaryIndex', $value->user1_id) }}">
                                    <div class="d-flex align-items-center">
                                        @if ($value->user1->avatar != '')
                                            <img src="{{ asset('storage/') }}/image/avatar/{{ $value->user1->avatar }}"
                                                alt="" width="50" height="50" class="rounded-circle">
                                        @else
                                            <img src="{{ asset('Admin/') }}/images/profile/user-1.jpg" alt=""
                                                width="50" height="50" class="rounded-circle">
                                        @endif

                                        <div class="ms-2 mt-4">
                                            <p><strong>{{ $value->user1->name }}</strong>
                                                {{-- <br> --}}
                                            </p>
                                        </div>
                                    </div>
                                </a>
                                {{-- <hr> --}}
                            </div>
                        @endforeach

                        </div>
                        <div class="col-sm-6">
                            <p class="border-bottom text-center">Đang theo dõi <span style="color: #FF9966">{{$count_following->count()}}</span>người</p>
                            @foreach ($count_following as $value)
                            <div class="row mt-1">
                                <a href="{{ route('my_diaryIndex', $value->user1_id) }}">
                                    <div class="d-flex align-items-center">
                                        @if ($value->user2->avatar != '')
                                            <img src="{{ asset('storage/') }}/image/avatar/{{ $value->user2->avatar }}"
                                                alt="" width="50" height="50" class="rounded-circle">
                                        @else
                                            <img src="{{ asset('Admin/') }}/images/profile/user-1.jpg" alt=""
                                                width="50" height="50" class="rounded-circle">
                                        @endif

                                        <div class="ms-2 mt-4">
                                            <p><strong>{{ $value->user2->name }}</strong>
                                            </p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
