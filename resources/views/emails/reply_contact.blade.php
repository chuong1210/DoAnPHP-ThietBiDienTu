<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Phản hồi liên hệ</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            line-height: 1.6;
            color: #1E293B;
            background-color: #f5f5f5;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #FFF5F7;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
        .header {
            background: linear-gradient(135deg, #FF3B3F 0%, #FF6B81 100%);
            color: white;
            padding: 32px 24px;
            text-align: center;
        }
        .header h1 {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 8px;
        }
        .header p {
            font-size: 14px;
            opacity: 0.95;
        }
        .content {
            padding: 32px 24px;
        }
        .greeting {
            font-size: 16px;
            margin-bottom: 16px;
            color: #1E293B;
        }
        .greeting strong {
            color: #FF3B3F;
        }
        .message-box {
            background-color: white;
            border-left: 4px solid #FF6B81;
            padding: 20px;
            margin: 24px 0;
            border-radius: 4px;
        }
        .message-box p {
            font-size: 15px;
            line-height: 1.8;
            color: #1E293B;
        }
        .footer-section {
            margin-top: 32px;
            padding-top: 20px;
            border-top: 1px solid #F0D9DE;
        }
        .footer-text {
            font-size: 14px;
            color: #666;
            line-height: 1.6;
        }
        .divider {
            height: 1px;
            background-color: #F0D9DE;
            margin: 20px 0;
        }
        .signature {
            color: #1E293B;
            font-size: 15px;
            margin-top: 16px;
        }
        .signature strong {
            color: #FF3B3F;
            display: block;
            margin-top: 8px;
        }
        .cta-button {
            display: inline-block;
            background: linear-gradient(135deg, #FF3B3F 0%, #FF6B81 100%);
            color: white;
            padding: 12px 28px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 500;
            margin-top: 16px;
            font-size: 14px;
        }
        .cta-button:hover {
            opacity: 0.95;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="header">
            <h1>📧 Phản hồi liên hệ của bạn</h1>
            <p>Cảm ơn bạn đã liên hệ với chúng tôi</p>
        </div>

        <!-- Content -->
        <div class="content">
            <div class="greeting">
                Xin chào <strong>{{ $contact->name }}</strong>,
            </div>

            <p style="font-size: 15px; color: #1E293B; margin-bottom: 16px;">
                Chúng tôi đã nhận được tin nhắn của bạn và rất vui lòng được phản hồi.
            </p>

            <!-- Message Box -->
            <div class="message-box">
                {!! nl2br(e($replyMessage)) !!}
            </div>

            <!-- Divider -->
            <div class="divider"></div>

            <!-- Footer Section -->
            <div class="footer-section">
                <p class="footer-text">
                    Nếu bạn có thêm bất kỳ câu hỏi nào, vui lòng không ngần ngại liên hệ với chúng tôi.
                </p>

                <div class="signature">
                    Trân trọng,
                    <strong>Shop của bạn</strong>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
