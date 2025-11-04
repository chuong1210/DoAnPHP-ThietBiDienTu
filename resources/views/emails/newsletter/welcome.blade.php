<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chào mừng bạn đến Tech Shop!</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #f8fafc;
            color: #1e293b;
            line-height: 1.6;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        }

        .header {
            background: linear-gradient(135deg, #0066FF, #00B4D8);
            padding: 40px 30px;
            text-align: center;
            color: white;
        }

        .header h1 {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .header p {
            font-size: 16px;
            opacity: 0.9;
        }

        .content {
            padding: 40px 30px;
            text-align: center;
        }

        .content h2 {
            font-size: 24px;
            margin-bottom: 16px;
            color: #0066FF;
        }

        .content p {
            font-size: 16px;
            color: #475569;
            margin-bottom: 20px;
        }

        .highlight {
            background: #f0f7ff;
            color: #0066FF;
            padding: 12px 20px;
            border-radius: 12px;
            font-weight: 600;
            display: inline-block;
            margin: 15px 0;
            font-size: 18px;
        }

        .benefits {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            margin: 30px 0;
            text-align: left;
        }

        .benefit {
            background: #f8fafc;
            padding: 16px;
            border-radius: 12px;
            border-left: 4px solid #0066FF;
        }

        .benefit i {
            color: #0066FF;
            margin-right: 8px;
        }

        .cta-button {
            display: inline-block;
            background: linear-gradient(135deg, #0066FF, #00B4D8);
            color: white;
            padding: 14px 32px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 600;
            margin: 20px 0;
            font-size: 16px;
            box-shadow: 0 6px 15px rgba(0, 102, 255, 0.3);
            transition: all 0.3s;
        }

        .cta-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0, 102, 255, 0.4);
        }

        .footer {
            background: #1e293b;
            color: #94a3b8;
            padding: 30px;
            text-align: center;
            font-size: 14px;
        }

        .footer a {
            color: #00B4D8;
            text-decoration: none;
        }

        .social {
            margin: 20px 0;
        }

        .social a {
            color: #94a3b8;
            margin: 0 10px;
            font-size: 20px;
            transition: color 0.3s;
        }

        .social a:hover {
            color: #00B4D8;
        }

        @media (max-width: 480px) {
            .benefits {
                grid-template-columns: 1fr;
            }

            .header,
            .content {
                padding: 30px 20px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>Chào Mừng Bạn!</h1>
            <p>Đã đăng ký nhận tin thành công tại Tech Shop</p>
        </div>

        <!-- Content -->
        <div class="content">
            <h2>Cảm ơn bạn đã tin tưởng!</h2>
            <p>Email của bạn đã được ghi nhận:</p>
            <div class="highlight">{{ $email }}</div>
            <p>Bạn sẽ nhận được <strong>ưu đãi độc quyền</strong> và <strong>sản phẩm mới nhất</strong> từ chúng tôi!
            </p>

            <!-- Benefits -->
            <div class="benefits">
                <div class="benefit">
                    <strong>Giảm 10%</strong> cho đơn hàng đầu tiên
                </div>
                <div class="benefit">
                    <strong>Miễn phí ship</strong> toàn quốc
                </div>
                <div class="benefit">
                    <strong>Thông báo flash sale</strong> sớm nhất
                </div>
                <div class="benefit">
                    <strong>Hỗ trợ 24/7</strong> qua Zalo
                </div>
            </div>

            <!-- CTA -->
            <a href="{{ url('/client/products-all') }}" class="cta-button">
                Khám Phá Sản Phẩm Ngay
            </a>
        </div>

        <!-- Footer -->
        <div class="footer">
            <div class="social">
                <a href="#"><i class="fab fa-facebook"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
                <a href="#"><i class="fab fa-youtube"></i></a>
            </div>
            <p>Tech Shop – Công nghệ & Chất lượng</p>
            <p><a href="#">Hủy đăng ký</a> bất kỳ lúc nào nếu bạn không muốn nhận tin.</p>
            <p>&copy; {{ date('Y') }} Tech Shop. All rights reserved.</p>
        </div>
    </div>
</body>

</html>