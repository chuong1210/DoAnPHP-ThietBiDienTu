@extends('client.layouts.client')
@section('title', 'Hỗ Trợ Khách Hàng')
@php
    $hideSidebar = true;
@endphp

@section('styles')
    <style>
        :root {
            --primary: #0066FF;
            --secondary: #00B4D8;
            --bg: #F8FAFC;
            --text: #1E293B;
            --neutral: #CBD5E1;
            --success: #10B981;
            --warning: #F59E0B;
            --danger: #EF4444;
        }

        .support-hero {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            padding: 4rem 0;
            margin-bottom: 3rem;
            border-radius: 0 0 2rem 2rem;
            position: relative;
            overflow: hidden;
        }

        .support-hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="none"><path d="M0,0 L100,30 L100,100 L0,100 Z" fill="rgba(255,255,255,0.1)"/></svg>') no-repeat bottom;
            background-size: cover;
        }

        .support-card {
            border: 1.5px solid var(--neutral);
            border-radius: 16px;
            padding: 1.5rem;
            transition: all 0.3s ease;
            background: white;
            height: 100%;
        }

        .support-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
            border-color: var(--primary);
        }

        .contact-item {
            display: flex;
            align-items: center;
            padding: 1rem;
            border-radius: 12px;
            background: var(--bg);
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .contact-item:hover {
            background: white;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            transform: translateX(4px);
        }

        .contact-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            flex-shrink: 0;
        }

        /* === FAQ STYLES === */
        .faq-item {
            background: white;
            border: 1.5px solid var(--neutral);
            border-radius: 12px;
            margin-bottom: 1rem;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .faq-item.active {
            border-color: var(--primary);
            box-shadow: 0 4px 12px rgba(0, 102, 255, 0.1);
        }

        .faq-question {
            padding: 1.25rem 1.5rem;
            font-weight: 600;
            color: var(--text);
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            user-select: none;
            transition: background 0.3s ease;
        }

        .faq-question:hover {
            background: var(--bg);
        }

        .faq-question i {
            color: var(--primary);
            font-size: 0.875rem;
            transition: transform 0.3s ease;
            flex-shrink: 0;
            margin-left: 1rem;
        }

        .faq-item.active .faq-question i {
            transform: rotate(180deg);
        }

        .faq-answer {
            max-height: 0;
            overflow: hidden;
            padding: 0 1.5rem;
            color: #64748B;
            line-height: 1.6;
            transition: max-height 0.4s ease, padding 0.4s ease;
        }

        .faq-answer.show {
            max-height: 800px;
            padding: 0 1.5rem 1.5rem;
        }

        /* === FORM STYLES === */
        .form-control,
        .form-select {
            border: 1.5px solid var(--neutral);
            border-radius: 12px;
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(0, 102, 255, 0.1);
            outline: none;
        }

        /* CHỈ hiện lỗi SAU KHI SUBMIT */
        .was-validated .form-control:invalid,
        .form-control.is-invalid {
            border-color: var(--danger) !important;
            padding-right: calc(1.5em + 0.75rem);
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23dc3545'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right calc(0.375em + 0.1875rem) center;
            background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
        }

        .was-validated .form-control:valid {
            border-color: var(--success);
        }

        /* Invalid feedback CHỈ hiện khi có class .was-validated */
        .invalid-feedback {
            display: none;
            color: var(--danger);
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        .was-validated .form-control:invalid~.invalid-feedback,
        .form-control.is-invalid~.invalid-feedback {
            display: block;
        }

        .server-error {
            display: block !important;
            color: var(--danger);
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        .nav-tabs .nav-link {
            border: none;
            color: var(--text);
            font-weight: 600;
            padding: 0.75rem 1.5rem;
            border-radius: 12px;
            margin: 0 0.5rem;
            transition: all 0.3s ease;
        }

        .nav-tabs .nav-link.active {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
        }

        .nav-tabs .nav-link:hover {
            background: var(--bg);
        }

        .btn-submit {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border: none;
            border-radius: 12px;
            padding: 0.75rem 2rem;
            font-weight: 600;
            color: white;
            transition: all 0.3s ease;
        }

        .btn-submit:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 102, 255, 0.3);
        }

        .btn-submit:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .hotline-badge {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: linear-gradient(135deg, #EF4444, #DC2626);
            color: white;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
            font-weight: 700;
            box-shadow: 0 8px 20px rgba(239, 68, 68, 0.4);
            z-index: 1000;
            animation: pulse 2s infinite;
            cursor: pointer;
        }

        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.7);
            }

            70% {
                box-shadow: 0 0 0 15px rgba(239, 68, 68, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(239, 68, 68, 0);
            }
        }
    </style>
@endsection

@section('content')
    <!-- Hero Section -->
    <section class="support-hero text-center position-relative">
        <div class="container position-relative">
            <h1 class="display-4 fw-bold mb-3">Hỗ Trợ Khách Hàng 24/7</h1>
            <p class="lead mb-4">Chúng tôi luôn sẵn sàng hỗ trợ bạn!</p>
            <div class="d-flex justify-content-center gap-3 flex-wrap">
                <a href="tel:19001000" class="btn btn-light btn-lg px-4">
                    <i class="fas fa-phone-volume me-2"></i> 1900 1000
                </a>
                <a href="https://zalo.me/0901234567" target="_blank" class="btn btn-light btn-lg px-4">
                    <i class="fab fa-facebook-messenger me-2"></i> Chat Zalo
                </a>
            </div>
        </div>
    </section>

    <div class="container">
        <div class="row g-4">
            <!-- Liên hệ nhanh -->
            <div class="col-lg-4">
                <div class="support-card">
                    <h5 class="fw-bold mb-4 text-primary">
                        <i class="fas fa-headset me-2"></i> Liên Hệ Nhanh
                    </h5>
                    <div class="contact-item mb-3" onclick="window.location.href='tel:19001000'">
                        <div class="contact-icon bg-danger text-white me-3">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div>
                            <strong>Hotline</strong><br>
                            <span class="text-success">1900 1000</span>
                        </div>
                    </div>
                    <div class="contact-item mb-3" onclick="window.open('https://zalo.me/0901234567', '_blank')">
                        <div class="contact-icon bg-info text-white me-3">
                            <i class="fab fa-facebook-messenger"></i>
                        </div>
                        <div>
                            <strong>Zalo</strong><br>
                            <span class="text-primary">0901 234 567</span>
                        </div>
                    </div>
                    <div class="contact-item" onclick="window.location.href='mailto:support@techshop.vn'">
                        <div class="contact-icon bg-warning text-white me-3">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div>
                            <strong>Email</strong><br>
                            <span class="text-muted">support@techshop.vn</span>
                        </div>
                    </div>
                </div>

                <!-- Giờ làm việc -->
                <div class="support-card mt-4">
                    <h6 class="fw-bold text-success">
                        <i class="fas fa-clock me-2"></i> Giờ Làm Việc
                    </h6>
                    <hr class="my-2">
                    <p class="small mb-1"><strong>Thứ 2 - Thứ 6:</strong> 8:00 - 21:00</p>
                    <p class="small mb-1"><strong>Thứ 7, CN:</strong> 9:00 - 18:00</p>
                    <p class="small text-danger mb-0"><strong>Lễ, Tết:</strong> Nghỉ</p>
                </div>
            </div>

            <!-- FAQ + Hướng dẫn -->
            <div class="col-lg-8">
                <!-- Tabs -->
                <ul class="nav nav-tabs mb-4" id="supportTabs" role="tablist">
                    <li class="nav-item">
                        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#faq">
                            Câu Hỏi Thường Gặp
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#guides">
                            Hướng Dẫn
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#contact">
                            Liên Hệ
                        </button>
                    </li>
                </ul>

                <div class="tab-content">
                    <!-- FAQ -->
                    <div class="tab-pane fade show active" id="faq">
                        <div id="faqList">
                            @php
                                $groups = [
                                    'order' => ['Đặt hàng', 'fas fa-shopping-bag'],
                                    'payment' => ['Thanh toán', 'fas fa-credit-card'],
                                    'shipping' => ['Giao hàng', 'fas fa-truck'],
                                    'warranty' => ['Bảo hành', 'fas fa-shield-alt'],
                                    'return' => ['Đổi trả', 'fas fa-sync-alt'],
                                ];
                            @endphp

                            @forelse($groups as $key => [$title, $icon])
                                @if(isset($faqs[$key]) && $faqs[$key]->count() > 0)
                                    <div class="mb-5">
                                        <h5 class="mb-3 fw-bold text-primary d-flex align-items-center">
                                            <i class="{{ $icon }} me-2"></i> {{ $title }}
                                        </h5>
                                        @foreach($faqs[$key] as $faq)
                                            <div class="faq-item">
                                                <div class="faq-question" onclick="toggleFAQ(this)">
                                                    {{ $faq->question }}
                                                    <i class="fas fa-chevron-down"></i>
                                                </div>
                                                <div class="faq-answer">
                                                    {!! nl2br($faq->answer) !!}
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            @empty
                                <div class="text-center py-5 text-muted">
                                    <i class="fas fa-info-circle fa-2x mb-3"></i>
                                    <p>Chưa có câu hỏi thường gặp nào.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Hướng dẫn -->
                    <div class="tab-pane fade" id="guides">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="support-card text-center p-4">
                                    <i class="fas fa-shopping-bag fa-3x text-primary mb-3"></i>
                                    <h6>Hướng Dẫn Mua Hàng</h6>
                                    <a href="#" class="btn btn-outline-primary btn-sm mt-2">Xem ngay</a>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="support-card text-center p-4">
                                    <i class="fas fa-shield-alt fa-3x text-success mb-3"></i>
                                    <h6>Chính Sách Bảo Hành</h6>
                                    <a href="#" class="btn btn-outline-success btn-sm mt-2">Xem ngay</a>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="support-card text-center p-4">
                                    <i class="fas fa-truck fa-3x text-warning mb-3"></i>
                                    <h6>Chính Sách Vận Chuyển</h6>
                                    <a href="#" class="btn btn-outline-warning btn-sm mt-2">Xem ngay</a>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="support-card text-center p-4">
                                    <i class="fas fa-sync-alt fa-3x text-danger mb-3"></i>
                                    <h6>Chính Sách Đổi Trả</h6>
                                    <a href="#" class="btn btn-outline-danger btn-sm mt-2">Xem ngay</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Form liên hệ -->
                    <div class="tab-pane fade" id="contact">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fas fa-check-circle me-2"></i>
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="fas fa-exclamation-circle me-2"></i>
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <form action="{{ route('client.support.contact') }}" method="POST" id="contactForm" novalidate>
                            @csrf

                            <div class="mb-3">
                                <label class="form-label">Họ tên <span class="text-danger">*</span></label>
                                <input type="text" name="name"
                                    class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                    value="{{ old('name') }}" required minlength="2" maxlength="60"
                                    placeholder="Nguyễn Văn A">
                                <div class="invalid-feedback">
                                    @if($errors->has('name'))
                                        <span class="server-error">{{ $errors->first('name') }}</span>
                                    @else
                                        Vui lòng nhập họ tên hợp lệ (2-60 ký tự).
                                    @endif
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" name="email"
                                    class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                                    value="{{ old('email') }}" required maxlength="100" placeholder="you@example.com">
                                <div class="invalid-feedback">
                                    @if($errors->has('email'))
                                        <span class="server-error">{{ $errors->first('email') }}</span>
                                    @else
                                        Vui lòng nhập email hợp lệ.
                                    @endif
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Số điện thoại</label>
                                <input type="text" name="phone"
                                    class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}"
                                    value="{{ old('phone') }}" maxlength="10" minlength="10" pattern="0[0-9]{9}"
                                    placeholder="0901234567">
                                <div class="invalid-feedback">
                                    @if($errors->has('phone'))
                                        <span class="server-error">{{ $errors->first('phone') }}</span>
                                    @else
                                        Số điện thoại phải có 10 chữ số, bắt đầu bằng 0.
                                    @endif
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Tiêu đề <span class="text-danger">*</span></label>
                                <input type="text" name="subject"
                                    class="form-control {{ $errors->has('subject') ? 'is-invalid' : '' }}"
                                    value="{{ old('subject') }}" required minlength="10" maxlength="120"
                                    placeholder="Vấn đề về đơn hàng #12345">
                                <div class="invalid-feedback">
                                    @if($errors->has('subject'))
                                        <span class="server-error">{{ $errors->first('subject') }}</span>
                                    @else
                                        Tiêu đề phải từ 10-120 ký tự.
                                    @endif
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Nội dung <span class="text-danger">*</span></label>
                                <textarea name="message"
                                    class="form-control {{ $errors->has('message') ? 'is-invalid' : '' }}" rows="5" required
                                    minlength="20" maxlength="2000"
                                    placeholder="Mô tả chi tiết vấn đề của bạn...">{{ old('message') }}</textarea>
                                <small class="text-muted float-end" id="charCount">0/2000</small>
                                <div class="invalid-feedback">
                                    @if($errors->has('message'))
                                        <span class="server-error">{{ $errors->first('message') }}</span>
                                    @else
                                        Nội dung phải từ 20-2000 ký tự.
                                    @endif
                                </div>
                            </div>

                            <!-- reCAPTCHA v2 -->
                            <div class="mb-3">
                                <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.site_key') }}"></div>
                                @if($errors->has('g-recaptcha-response'))
                                    <div class="server-error">{{ $errors->first('g-recaptcha-response') }}</div>
                                @endif
                            </div>

                            <!-- Honeypot -->
                            <div style="display: none;">
                                <input type="text" name="website" tabindex="-1" autocomplete="off">
                            </div>

                            <button type="submit" class="btn btn-submit w-100" id="submitBtn">
                                <i class="fas fa-paper-plane me-2"></i> Gửi Yêu Cầu
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Hotline nổi -->
    <div class="hotline-badge" onclick="window.location.href='tel:19001000'">
        <i class="fas fa-phone fa-lg"></i>
        <small>GỌI NGAY</small>
    </div>
@endsection

@section('scripts')
    <!-- TẢI reCAPTCHA v2 API -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

    <script>
        // === HÀM TOGGLE FAQ ===
        function toggleFAQ(element) {
            const answer = element.nextElementSibling;
            const icon = element.querySelector('i');
            const item = element.parentElement;

            // Đóng tất cả FAQ khác
            document.querySelectorAll('.faq-item').forEach(faq => {
                if (faq !== item) {
                    faq.classList.remove('active');
                    faq.querySelector('.faq-answer').classList.remove('show');
                    const otherIcon = faq.querySelector('.faq-question i');
                    if (otherIcon) {
                        otherIcon.className = 'fas fa-chevron-down';
                    }
                }
            });

            // Toggle FAQ hiện tại
            item.classList.toggle('active');
            answer.classList.toggle('show');

            // Toggle icon
            if (item.classList.contains('active')) {
                icon.className = 'fas fa-chevron-up';
            } else {
                icon.className = 'fas fa-chevron-down';
            }
        }

        // === DOM LOADED ===
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('contactForm');
            const message = document.querySelector('[name="message"]');
            const charCount = document.getElementById('charCount');
            const submitBtn = document.getElementById('submitBtn');

            // === ĐẾM KÝ TỰ ===
            if (message && charCount) {
                charCount.textContent = `${message.value.length}/2000`;

                message.addEventListener('input', function () {
                    const len = this.value.length;
                    charCount.textContent = `${len}/2000`;
                    charCount.style.color = len > 1900 ? 'red' : len > 1500 ? 'orange' : '';
                });
            }

            // === VALIDATION FORM (CHỈ KHI SUBMIT) ===
            if (form) {
                form.addEventListener('submit', function (e) {
                    // Kiểm tra validity
                    if (!form.checkValidity()) {
                        e.preventDefault();
                        e.stopPropagation();
                    }

                    // QUAN TRỌNG: CHỈ thêm class sau khi submit
                    form.classList.add('was-validated');

                    // Vô hiệu hóa nút submit nếu form hợp lệ
                    if (form.checkValidity()) {
                        submitBtn.disabled = true;
                        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Đang gửi...';
                    }
                }, false);
            }

            // === RESET reCAPTCHA NẾU CÓ LỖI ===
            @if($errors->has('g-recaptcha-response'))
                setTimeout(function () {
                    if (typeof grecaptcha !== 'undefined') {
                        grecaptcha.reset();
                    }
                }, 500);
            @endif

                // === TỰ ĐỘNG FOCUS VÀO FIELD LỖI ĐẦU TIÊN (nếu có lỗi từ server) ===
                @if($errors->any())
                    const firstError = document.querySelector('.is-invalid');
                    if (firstError) {
                        // Chuyển sang tab Contact nếu có lỗi
                        const contactTab = document.querySelector('[data-bs-target="#contact"]');
                        if (contactTab) {
                            contactTab.click();
                        }

                        // Focus vào field lỗi
                        setTimeout(() => {
                            firstError.focus();
                            firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        }, 300);
                    }
                @endif
    });
    </script>
@endsection