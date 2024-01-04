@extends('Admin.layouts.master')

@section('title', 'Quản lý tài khoản')

@section('content')
    <style>
        .btn-change-img {
            display: none;
            /* Thay đổi từ opacity thành display: none */
            transition: display 0.3s ease-in-out;
            /* Thay đổi transition từ opacity sang display */
        }

        .col-md-3:hover .btn-change-img {
            display: block;
            /* Hiển thị nút khi hover vào col-md-3 */
        }
    </style>
    <div class="container-fluid ">
        {{-- tiêu đề trang --}}
        <div class="row ">
            <div class="card border">
                <div class="card-body row">
                    {{-- <h5 class="card-title fw-semibold mb-4">Danh mục sản phẩm</h5> --}}
                    <div class="col-md-7 col-sm-12 mb-1">
                        <h5 class="mb-0 card-title fw-semibold">Thông tin cá nhân</h5>
                    </div>
                    <div class="col-md-3 col-sm-12 mb-1">
                        <a href="" data-bs-toggle="modal" data-bs-target="#exampleModal_edit"> <button type="button"
                                class="btn btn-primary float-end" title="Tạo bài viết mới">Cập nhật
                                thông tin cơ
                                bản</button></a>
                    </div>
                    <div class="col-md-2 col-sm-12">
                        <a href="" data-bs-toggle="modal" data-bs-target="#exampleModal_edit_pass"> <button
                                type="button" class="btn btn-success float-end" title="Tạo bài viết mới">Đổi mật
                                khẩu</button></a>
                    </div>
                </div>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success" id="success-alert">
                {{ session('success') }}
                <span type="button" class="X-close float-end" data-dismiss="alert" aria-label="Close">
                    {{-- <span aria-hidden="true">&times;</span> --}}<i class="ti ti-x"></i>
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
        <div class="row d-flex align-items-stretch">
            <div class="card border">
                <div class="row card-body">
                    <div class="col-md-3 d-flex justify-content-center align-items-center position-relative">
                        <img src="{{ asset('Admin/') }}/images/profile/user-1.jpg" alt="" width="160"
                            height="160" class="rounded-circle">
                        <button
                            class="btn btn-primary btn-change-img position-absolute top-50 start-50 translate-middle">Thay
                            đổi ảnh</button>
                    </div>
                    <div class="col-md-9">
                        <h2>Thông tin người dùng</h2>
                        <p><strong>Tên: </strong>{{ Auth::user()->name }}</p>
                        <p><strong>Email: </strong>{{ Auth::user()->email }}</p>
                        <p><strong>số điện thoại: </strong>{{ Auth::user()->number_phone }}</p>
                        <p>
                            <strong>Giới tính:
                            </strong>{{ Auth::user()->sex === 1 ? 'Nam' : (Auth::user()->sex === 2 ? 'Nữ' : 'Giới tính không xác định') }}
                        </p>
                        <p><strong>Địa chỉ: </strong>{{ Auth::user()->address }}</p>
                    </div>
                </div>
            </div>
        </div>

    </div>


    <!-- Modal edit account-->
    <div class="modal fade" id="exampleModal_edit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Cập nhật thông tin người dùng</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('accountUpdate') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" value="{{ Auth::id() }}">
                    <div class="modal-body ">
                        <div class="row m-1">
                            <label for="recipient-name" class="col-form-label">Tên người dùng <span
                                    style="color: red">*</span></label>
                            <input type="text" class="form-control" id="recipient-name" name="name"
                                value="{{ Auth::user()->name }}">
                            @if ($errors->has('name'))
                                <span class="text-danger" role="alert">{{ $errors->first('name') }}</span>
                            @endif
                        </div>

                        <div class="row m-1">
                            <label for="recipient-phone" class="col-form-label">Số điện thoại</label>
                            <input type="number" class="form-control" id="recipient-phone" name="number_phone"
                                value="{{ Auth::user()->number_phone }}">
                            @if ($errors->has('number_phone'))
                                <span class="text-danger" role="alert">{{ $errors->first('number_phone') }}</span>
                            @endif
                        </div>

                        <div class="row m-1">
                            <label for="recipient-sex" class="col-form-label">Chọn giới tính</label>
                            <select name="sex" id="recipient-sex" class="form-select">
                                <option value="1" {{ Auth::user()->sex === 1 ? 'selected' : '' }}>Nam</option>
                                <option value="2" {{ Auth::user()->sex === 2 ? 'selected' : '' }}>Nữ</option>
                                <option value="3"
                                    {{ Auth::user()->sex !== 1 && Auth::user()->sex !== 2 ? 'selected' : '' }}>Giới tính
                                    không xác định</option>
                            </select>
                            @if ($errors->has('sex'))
                                <span class="text-danger" role="alert">{{ $errors->first('sex') }}</span>
                            @endif
                        </div>
                        <div class="row m-1">
                            <label for="recipient-address" class="col-form-label">Địa chỉ</label>
                            <input type="text" class="form-control" id="recipient-address" name="address"
                                value="{{ Auth::user()->address }}">
                            @if ($errors->has('address'))
                                <span class="text-danger" role="alert">{{ $errors->first('address') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>

                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal edit pass-->
    <div class="modal fade" id="exampleModal_edit_pass" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Đổi mật khẩu</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('accountUpdatePass') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" value="{{ Auth::id() }}">
                    <div class="modal-body ">
                        <div class="row m-1">
                            <label for="recipient-name" class="col-form-label">Mật khẩu cũ<span
                                    style="color: red">*</span></label>
                            <input type="password" class="form-control" id="recipient-name" name="password_old"
                                value="{{ old('password_old') }}">
                            @if ($errors->has('password_old'))
                                <span class="text-danger" role="alert">{{ $errors->first('password_old') }}</span>
                            @endif
                        </div>

                        <div class="row m-1">
                            <label for="recipient-phone" class="col-form-label">Mật khẩu mới<span
                                    style="color: red">*</span></label>
                            <input type="text" class="form-control" id="recipient-phone" name="password"
                                value="{{ old('password') }}">
                            @if ($errors->has('password'))
                                <span class="text-danger" role="alert">{{ $errors->first('password') }}</span>
                            @endif
                        </div>
                        <div class="row m-1">
                            <label for="recipient-phone" class="col-form-label">Nhập lại mật khẩu mới<span
                                    style="color: red">*</span></label>
                            <input type="text" class="form-control" id="recipient-phone"
                                name="password_confirmation" value="{{ old('password_confirmation') }}">
                            @if ($errors->has('password_confirmation'))
                                <span class="text-danger"
                                    role="alert">{{ $errors->first('password_confirmation') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>

                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


@endsection
