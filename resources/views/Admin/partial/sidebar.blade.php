<div>
    <div class="brand-logo d-flex align-items-center justify-content-between">
      <a href="#" class="text-nowrap logo-img">
        {{-- <img src="{{ asset('Admin/') }}/images/logos/dark-logo.svg" width="180" alt="" /> --}}
        <img src="{{ asset('Admin/') }}/images/logos/logo_main.png" width="200" alt="" />
      </a>
      <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
        <i class="ti ti-x fs-8"></i>
      </div>
    </div>

    <!-- Sidebar navigation-->
    <nav class="sidebar-nav scroll-sidebar mt-4" data-simplebar="">
        {{-- <label>Tìm kiếm theo hastag</label> --}}
        <form action="{{ route('my_diaryIndex', Auth::id()) }}" method="get"
            enctype="multipart/form-data">
            <div class="input-group">

                <input class="form-control" type="text" name="search" value=""
                    placeholder="Tìm kiếm người dùng">
                <button class="btn btn-primary" type="submit"><i class="ti ti-search"></i></button>
            </div>
        </form>
      <ul id="sidebarnav">
        <li class="nav-small-cap">
          <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
          <span class="hide-menu">Nhật ký điện tử</span>
        </li>

        <li class="sidebar-item mt-3">
          <a class="sidebar-link" href="{{route('index_test')}}" aria-expanded="false">
            <span>
              <i class="ti ti-layout-dashboard"></i>
            </span>
            <span class="hide-menu">Trang chủ</span>
          </a>
        </li>
       {{-- <li class="nav-small-cap">
          <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
          <span class="hide-menu">Sản phẩm</span>
        </li> --}}

        <li class="sidebar-item">
          <a class="sidebar-link" href="{{route('my_diaryIndex', Auth::id() )}}" aria-expanded="false">
          {{-- <a class="sidebar-link" href="{{ route('my_diaryIndex', ['id' => Auth::id()]) }}" aria-expanded="false"> --}}

            <span>
              <i class="ti ti-article"></i>
            </span>
            <span class="hide-menu">Trang cá nhân</span>
          </a>
        </li>
        <li class="nav-small-cap">
            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
            <span class="hide-menu">Tài khoản</span>
          </li>

          {{-- Chưa có --}}
          <li class="sidebar-item mt-3">
            <a class="sidebar-link" href="{{route('index_test')}}" aria-expanded="false">
              <span>
                <i class="ti ti-layout-dashboard"></i>
              </span>
              <span class="hide-menu">Quản lý tài khoản</span>
            </a>
          </li>

        <li class="nav-small-cap">
            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
            <span class="hide-menu">Danh sách công việc</span>
          </li>

          {{-- Chưa có --}}
          <li class="sidebar-item mt-3">
            <a class="sidebar-link" href="{{route('index_test')}}" aria-expanded="false">
              <span>
                <i class="ti ti-layout-dashboard"></i>
              </span>
              <span class="hide-menu">Lên lịch</span>
            </a>
          </li>
          {{-- Chưa có --}}
          <li class="sidebar-item mt-3">
            <a class="sidebar-link" href="{{route('index_test')}}" aria-expanded="false">
              <span>
                <i class="ti ti-layout-dashboard"></i>
              </span>
              <span class="hide-menu">Công việc đã hoàn thành</span>
            </a>
          </li>

      </ul>
    </nav>
    <!-- End Sidebar navigation -->
  </div>
