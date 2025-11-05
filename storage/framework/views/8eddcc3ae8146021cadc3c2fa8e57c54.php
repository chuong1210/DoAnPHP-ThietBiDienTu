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
            background-color: #FFFFFF;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 102, 255, 0.1);
        }
        /* Tech Blue Pro gradient header -->
        .header {
            background: linear-gradient(135deg, #0066FF 0%, #00B4D8 100%);
            color: white;
            padding: 40px 32px;
            text-align: center;
        }
        .header h1 {
            font-size: 26px;
            font-weight: 700;
            margin-bottom: 8px;
        }
        .header p {
            font-size: 14px;
            opacity: 0.95;
        }
        .content {
            padding: 40px 32px;
        }
        .greeting {
            font-size: 16px;
            margin-bottom: 20px;
            color: #1E293B;
            font-weight: 500;
        }
        .greeting strong {
            color: #0066FF;
        }
        .message-box {
            background: linear-gradient(135deg, #F8FAFC 0%, #E0F2FE 100%);
            border-left: 4px solid #0066FF;
            padding: 24px;
            margin: 28px 0;
            border-radius: 8px;
        }
        .message-box p {
            font-size: 15px;
            line-height: 1.8;
            color: #1E293B;
        }
        .footer-section {
            margin-top: 32px;
            padding-top: 24px;
            border-top: 1px solid #CBD5E1;
        }
        .footer-text {
            font-size: 14px;
            color: #64748B;
            line-height: 1.8;
        }
        .divider {
            height: 1px;
            background-color: #CBD5E1;
            margin: 24px 0;
        }
        .signature {
            color: #1E293B;
            font-size: 15px;
            margin-top: 20px;
        }
        .signature strong {
            color: #0066FF;
            display: block;
            margin-top: 8px;
            font-weight: 600;
        }
        .cta-button {
            display: inline-block;
            background: linear-gradient(135deg, #0066FF 0%, #00B4D8 100%);
            color: white;
            padding: 14px 32px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            margin-top: 20px;
            font-size: 14px;
            box-shadow: 0 4px 15px rgba(0, 102, 255, 0.3);
        }
        .cta-button:hover {
            opacity: 0.95;
        }
        .icon {
            display: inline-block;
            width: 40px;
            height: 40px;
            background: rgba(255,255,255,0.2);
            border-radius: 8px;
            text-align: center;
            line-height: 40px;
            margin-bottom: 16px;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header with icon -->
        <div class="header">
            <div class="icon">💬</div>
            <h1>Phản hồi từ chúng tôi</h1>
            <p>Cảm ơn bạn đã liên hệ</p>
        </div>

        <!-- Content -->
        <div class="content">
            <div class="greeting">
                Xin chào <strong><?php echo e($contact->name); ?></strong>,
            </div>

            <p style="font-size: 15px; color: #1E293B; margin-bottom: 20px; line-height: 1.8;">
                Chúng tôi đã nhận được tin nhắn của bạn và rất vui lòng được phản hồi bằng thông tin chi tiết dưới đây.
            </p>

            <!-- Message Box with gradient -->
            <div class="message-box">
                <p><?php echo nl2br(e($replyMessage)); ?></p>
            </div>

            <!-- Divider -->
            <div class="divider"></div>

            <!-- Footer Section -->
            <div class="footer-section">
                <p class="footer-text">
                    Nếu bạn có bất kỳ câu hỏi bổ sung nào hoặc cần hỗ trợ thêm, vui lòng đừng ngần ngại liên hệ với chúng tôi. Đội ngũ của chúng tôi sẵn sàng giúp đỡ.
                </p>

                <div class="signature">
                    Trân trọng,
                    <strong>Đội ngũ hỗ trợ của chúng tôi</strong>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
<?php /**PATH C:\Users\chuon\PHP\doanPHP\resources\views/emails/reply_contact.blade.php ENDPATH**/ ?>