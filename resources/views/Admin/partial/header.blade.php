<nav class="navbar navbar-expand-lg navbar-light">
    <ul class="navbar-nav">
      <li class="nav-item d-block d-xl-none">
        <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse" href="#">
          <i class="ti ti-menu-2"></i>
        </a>
      </li>
      <li class="nav-item">
        {{-- <a class="nav-link nav-icon-hover" href="#"> --}}
        <a  class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2" data-bs-toggle="dropdown"
        aria-expanded="false">
          <i class="ti ti-bell-ringing"></i>
          <div class="notification bg-primary rounded-circle"></div>
        </a>
        <div class="dropdown-menu dropdown-menu-start dropdown-menu-animate-up" aria-labelledby="drop2" id="message_body" >
            {{-- <div class="message-body" > --}}
              {{-- <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                <i class="ti ti-user fs-6"></i>
                <p class="mb-0 fs-3">My Profil111eProfil111eProfil111eProfil111e Profil111eProfil111eProfil111eProfil111e</p>
              </a>
              <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                <i class="ti ti-mail fs-6"></i>
                <p class="mb-0 fs-3">My Account</p>
              </a>
              <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                <i class="ti ti-list-check fs-6"></i>
                <p class="mb-0 fs-3">My Task</p>
              </a>
              <a href="./authentication-login.html" class="btn btn-outline-primary mx-3 mt-2 d-block">Logout</a> --}}
            {{-- </div> --}}
          </div>
      </li>

    </ul>
    <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
      <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
        <a href="{{route('showAccount')}}" target="_blank" class="btn btn-primary">Tài khoản</a>
        <li class="nav-item dropdown">
          <a class="nav-link nav-icon-hover" href="#" id="drop2" data-bs-toggle="dropdown"
            aria-expanded="false">
            @if ( Auth::user()->avatar != '' )
            <img src="{{ asset('storage/') }}/image/avatar/{{ Auth::user()->avatar }}" alt="" width="35" height="35" class="rounded-circle">

            @else

            <img src="{{ asset('Admin/') }}/images/profile/user-1.jpg" alt="" width="35" height="35" class="rounded-circle">
            @endif
          </a>
          <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
            <div class="message-body">
              <a href="{{route('showAccount')}}" class="d-flex align-items-center gap-2 dropdown-item">
                <i class="ti ti-user fs-6"></i>
                <p class="mb-0 fs-3">Thông tin của tôi</p>
              </a>
              {{-- <a href="#" class="d-flex align-items-center gap-2 dropdown-item">
                <i class="ti ti-mail fs-6"></i>
                <p class="mb-0 fs-3">My Account</p>
              </a> --}}
              <a href="#" class="d-flex align-items-center gap-2 dropdown-item">
                <i class="ti ti-list-check fs-6"></i>
                <p class="mb-0 fs-3">Công việc của tôi</p>
              </a>
              <form action="{{route('logout')}}"  method="POST">
                @csrf
                <button class="btn btn-outline-primary mx-3 mt-2 d-block center" type="submit">Logout</button>
            </form>
            {{-- <a type="submit" class="btn btn-outline-primary mx-3 mt-2 d-block">Logout</a> --}}
            </div>
          </div>
        </li>
      </ul>
    </div>
  </nav>
