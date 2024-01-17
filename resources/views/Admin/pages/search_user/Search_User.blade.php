@extends('Admin.layouts.master')

@section('title', 'Tìm kiếm người dùng')

@section('content')

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
                            <label>Hiển thị kết quả tìm kiếm người dùng: <span style="color: blue">
                                    {{ $searchTerm }}</span></label>
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
        <div class="row d-flex align-items-stretch">
            <div class="card border">
                <div class="card-body p-4">

                    {{-- {{ $category->links() }} --}}
                    @if ($search->count() > 0)
                        

                        @foreach ($search as $value)
                            <div class="row">
                                <a href="{{ route('my_diaryIndex', $value->id) }}">
                                    <div class="d-flex align-items-center">
                                        @if ($value->avatar != '')
                                            <img src="{{ asset('storage/') }}/image/avatar/{{ $value->avatar }}"
                                                alt="" width="50" height="50" class="rounded-circle">
                                        @else
                                            <img src="{{ asset('Admin/') }}/images/profile/user-1.jpg" alt=""
                                                width="50" height="50" class="rounded-circle">
                                        @endif

                                        <div class="ms-2 mt-4">
                                            <p><strong>{{ $value->name }}</strong>
                                                {{-- <br> --}}
                                            </p>
                                        </div>
                                    </div>
                                </a>
                                <hr>
                            </div>
                        @endforeach
                    @else
                        <p> Không có kết quả nào để hiển thị</p>
                    @endif

                </div>
            </div>
        </div>
    </div>
    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}

    <script>
        $(document).ready(function() {
            $.ajax({
                url: '{{ route('commentLoad') }}', // Đường dẫn của route đã tạo
                type: 'GET',

                success: function(data) {
                    console.log('data nè', data);
                    // $('#result').html(data);
                },
                error: function(error) {
                    console.log(error);
                }
            });
        });
    </script>
@endsection
