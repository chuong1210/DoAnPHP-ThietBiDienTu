<div class="top-bar">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h4 class="mb-0">@yield('page-title', 'Dashboard')</h4>
        </div>
        <div class="dropdown">
            <button class="btn btn-light dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown">
                <i class="fas fa-user"></i> {{ Auth::user()->full_name }}
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
                <li>
                    <a class="dropdown-item" href="#">
                        <i class="fas fa-user-circle"></i> Thông Tin
                    </a>
                </li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item text-danger">
                            <i class="fas fa-sign-out-alt"></i> Đăng Xuất
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</div>