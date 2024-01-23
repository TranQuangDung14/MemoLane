@extends('Admin.layouts.master')

@section('title', 'Thêm mới nhật ký')

@section('content')
    <div class="container-fluid">
        {{-- tiêu đề trang --}}
        <div class="row">
            <div class="card">
                <div class="card-body">
                    {{-- <h5 class="card-title fw-semibold mb-4">Danh mục sản phẩm</h5> --}}
                    @if (isset($editData))
                        <h5 class="mb-0 card-title fw-semibold ">Cập nhật bài viết </h5>
                    @else
                        <h5 class="mb-0 card-title fw-semibold ">Tạo nhật ký cá nhân </h5>
                    @endif
                </div>
            </div>
        </div>
        @if (session('error'))
            <div class="alert alert-danger" id="error-alert">
                {{ session('error') }}
                {{-- <span type="button" class="X-close float-end" data-dismiss="alert" aria-label="Close"> --}}
                <span type="button" class="X-close float-end" data-dismiss="alert" aria-label="Close">
                    <i class="ti ti-x"></i>
                </span>
            </div>
        @endif

        <div class="row d-flex align-items-stretch">
            <div class="card">
                <div class="card-body">
                    {{-- @if (isset($editData))
                        <form action="{{ route('categoryUpdate', @$editData->id) }}" method="PUT" enctype="multipart/form-data">
                        @else --}}
                    <form action="{{ route('my_diaryStore') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="mb-3 col-5">
                                <label for="title" class="form-label">Tên tiêu đề bài viết <span
                                        style="color: red">*</span></label>
                                <input type="text" class="form-control" name="title" id="title"
                                    value="{{ isset($editData) ? $editData->title : old('title') }}">
                                @if ($errors->has('title'))
                                    <span class="text-danger" role="alert">{{ $errors->first('title') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="input-effect sm2_mb_20 md_mb_20">
                                <label for="description" class="form-label">Nội dung <span
                                        style="color: red">*</span></label>
                                @if ($errors->has('description'))
                                    <br>
                                    <span class="text-danger" role="alert">{{ $errors->first('description') }}</span>
                                @endif
                                <textarea name="description" id="description">
                                {{ isset($editData) ? $editData->description : '' }}
                            </textarea>
                            </div>

                        </div>
                        <div class="text-center mt-5">
                            <a class="btn btn-outline-primary mr-20 btn-back"
                                href="{{ route('my_diaryIndex', Auth::id()) }}">Quay lại</a>
                            @if (isset($editData))
                                <button type="submit" class="btn btn-primary">Cập nhật</button>
                            @else
                                <button type="submit" class="btn btn-primary">Đăng</button>
                            @endif
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>


    <script>
        CKEDITOR.replace('description');
    </script>
@endsection
