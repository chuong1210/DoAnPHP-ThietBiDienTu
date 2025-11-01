  <!-- Sidebar Menu (Cột Trái) -->
  <div class="col-md-3 profile-sidebar">
      <div class="user-info">
          <div class="d-flex align-items-center mb-3">
              <div class="user-avatar me-3">
                  <i class="fas fa-user"></i>
              </div>
              <div>
                  <h5 class="mb-0 fw-bold">{{ Auth::user()->full_name ?? 'Khách Hàng' }}</h5>

              </div>
          </div>
      </div>

      <!-- Navigation Links -->
      <ul class="nav nav-pills flex-column" id="profileSidebar" role="tablist">
          <li class="nav-item" role="presentation">
              <button class="nav-link active" id="info-tab" data-bs-toggle="pill" data-bs-target="#profile-info"
                  type="button" role="tab" aria-selected="true">
                  <i class="fas fa-user-edit me-2"></i> Thông tin tài khoản
              </button>
          </li>
          <li class="nav-item" role="presentation">
              <button class="nav-link" id="password-tab" data-bs-toggle="pill" data-bs-target="#profile-password"
                  type="button" role="tab" aria-selected="false">
                  <i class="fas fa-lock me-2"></i> Đổi mật khẩu
              </button>
          </li>

            <li class="nav-item" role="presentation">
              <button class="nav-link" id="orders-tab" data-bs-toggle="pill" data-bs-target="#profile-orders"
                  type="button" role="tab" aria-selected="false">
                  <i class="fas fa-lock me-2"></i> Quản lý đơn hàng
              </button>
          </li>

          <li class="nav-item" role="presentation">
              <a href="{{ route('logout') }}" class="nav-link text-danger">
                  <i class="fas fa-sign-out-alt me-2"></i> Đăng xuất
              </a>
          </li>
      </ul>
  </div>
