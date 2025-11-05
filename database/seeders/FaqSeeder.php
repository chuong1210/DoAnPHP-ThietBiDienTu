<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    public function run()
    {
        $faqs = [
            // === THANH TOÁN ===
            [
                'category' => 'payment',
                'question' => 'Các hình thức thanh toán nào được hỗ trợ?',
                'answer' => "<strong>COD (Thanh toán khi nhận hàng)</strong><br>
                             <strong>Chuyển khoản ngân hàng</strong> (Vietcombank, Techcombank, MBBank...)<br>
                             <strong>Ví điện tử:</strong> MoMo, ZaloPay<br>
                             <strong>Thẻ tín dụng/ghi nợ</strong> (Visa, MasterCard)<br>
                             <strong>Trả góp 0%</strong> qua thẻ tín dụng hoặc Home Credit",
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'category' => 'payment',
                'question' => 'Thanh toán COD có an toàn không?',
                'answer' => "Rất an toàn! Bạn kiểm tra hàng trước khi trả tiền.<br>
                             <strong>Lưu ý:</strong> Chỉ áp dụng cho đơn dưới 10 triệu.",
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'category' => 'payment',
                'question' => 'Làm sao để thanh toán chuyển khoản?',
                'answer' => "1. Chọn <strong>Chuyển khoản</strong> khi thanh toán<br>
                             2. Chụp màn hình thông tin chuyển khoản<br>
                             3. Gửi ảnh + mã đơn hàng qua Zalo <strong>0901 234 567</strong><br>
                             4. Đơn sẽ được xử lý sau khi xác nhận",
                'sort_order' => 3,
                'is_active' => true,
            ],

            // === GIAO HÀNG ===
            [
                'category' => 'shipping',
                'question' => 'Thời gian giao hàng bao lâu?',
                'answer' => "<strong>Nội thành (Hà Nội, TP.HCM):</strong> 1-2 ngày<br>
                             <strong>Tỉnh khác:</strong> 2-5 ngày<br>
                             <strong>Miền núi, hải đảo:</strong> 5-7 ngày<br>
                             <small>Thời gian tính từ khi đơn được xác nhận</small>",
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'category' => 'shipping',
                'question' => 'Phí vận chuyển là bao nhiêu?',
                'answer' => "<strong>30.000đ</strong> cho mọi đơn hàng<br>
                             <strong class='text-success'>MIỄN PHÍ</strong> cho đơn từ <strong>1.000.000đ</strong><br>
<strong class='text-success'>MIỄN PHÍ 100%</strong> cho đơn từ <strong>2.000.000đ</strong>",
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'category' => 'shipping',
                'question' => 'Tôi có thể nhận hàng tại cửa hàng không?',
                'answer' => "Có! Chọn <strong>Nhận tại cửa hàng</strong> khi đặt hàng.<br>
                             Địa chỉ: <strong>123 Nguyễn Trãi, Q.5, TP.HCM</strong><br>
                             Thời gian: 8h - 21h (T2 - CN)",
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'category' => 'shipping',
                'question' => 'Làm sao để theo dõi đơn hàng?',
                'answer' => "1. Đăng nhập → <strong>Đơn hàng của tôi</strong><br>
                             2. Nhấn vào mã đơn → Xem trạng thái<br>
                             3. Hoặc tra cứu qua <a href='#' class='text-primary'>link tracking</a>",
                'sort_order' => 4,
                'is_active' => true,
            ],

            // === ĐỔI TRẢ & BẢO HÀNH ===
            [
                'category' => 'warranty',
                'question' => 'Chính sách bảo hành sản phẩm?',
                'answer' => "<strong>Điện thoại, laptop:</strong> 12 tháng chính hãng<br>
                             <strong>Phụ kiện:</strong> 6 tháng<br>
                             <strong>Pin, sạc:</strong> 6 tháng<br>
                             <strong>1 đổi 1</strong> trong 30 ngày nếu lỗi nhà sản xuất",
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'category' => 'warranty',
                'question' => 'Làm sao để bảo hành sản phẩm?',
                'answer' => "1. Mang <strong>hóa đơn + sản phẩm</strong> đến cửa hàng<br>
                             2. Hoặc gửi qua bưu điện (chúng tôi hỗ trợ phí ship)<br>
                             3. Thời gian xử lý: 3-7 ngày",
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'category' => 'return',
                'question' => 'Chính sách đổi trả?',
                'answer' => "<strong>Đổi trả trong 7 ngày</strong> nếu:<br>
                             • Lỗi kỹ thuật<br>
                             • Sản phẩm nguyên seal, đầy đủ hộp, phụ kiện<br>
                             <strong>Không áp dụng</strong> nếu đã sử dụng, trầy xước",
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'category' => 'return',
                'question' => 'Làm sao để đổi trả sản phẩm?',
'answer' => "1. Liên hệ Zalo <strong>0901 234 567</strong><br>
                             2. Gửi ảnh lỗi + video (nếu có)<br>
                             3. Chúng tôi sẽ hướng dẫn gửi hàng về<br>
                             4. Hoàn tiền hoặc đổi mới trong 48h",
                'sort_order' => 2,
                'is_active' => true,
            ],

            // === ĐẶT HÀNG & TÀI KHOẢN ===
            [
                'category' => 'order',
                'question' => 'Làm sao để đặt hàng?',
                'answer' => "1. Chọn sản phẩm → <strong>Thêm vào giỏ</strong><br>
                             2. Vào <strong>Giỏ hàng</strong> → <strong>Thanh toán</strong><br>
                             3. Điền thông tin → Chọn thanh toán → <strong>Đặt hàng</strong>",
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'category' => 'order',
                'question' => 'Tôi có thể đặt hàng qua điện thoại không?',
                'answer' => "Có! Gọi ngay <strong>1900 1000</strong><br>
                             Tư vấn viên sẽ hỗ trợ đặt hàng trực tiếp<br>
                             Thời gian: 8h - 21h",
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'category' => 'account',
                'question' => 'Làm sao để đăng ký tài khoản?',
                'answer' => "1. Nhấn <strong>Đăng ký</strong> ở góc trên<br>
                             2. Nhập email + mật khẩu<br>
                             3. Xác nhận qua email<br>
                             <small>Đăng ký để nhận ưu đãi!</small>",
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'category' => 'account',
                'question' => 'Quên mật khẩu phải làm sao?',
                'answer' => "1. Nhấn <strong>Quên mật khẩu?</strong><br>
                             2. Nhập email đăng ký<br>
                             3. Kiểm tra email → Nhấn link đặt lại<br>
                             4. Tạo mật khẩu mới",
                'sort_order' => 2,
                'is_active' => true,
            ],

            // === KHUYẾN MÃI & SẢN PHẨM ===
            [
                'category' => 'promotion',
                'question' => 'Làm sao để nhận mã giảm giá?',
                'answer' => "• Đăng ký tài khoản → Nhận <strong>50k</strong><br>
                             • Theo dõi Fanpage → Nhận mã <strong>Flash Sale</strong><br>
                             • Đơn đầu tiên → Tặng <strong>100k</strong>",
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'category' => 'promotion',
'question' => 'Mã giảm giá dùng được bao lâu?',
                'answer' => "Tùy chương trình:<br>
                             • Mã mới: 7 ngày<br>
                             • Flash Sale: 24h<br>
                             • Sinh nhật: 30 ngày",
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'category' => 'product',
                'question' => 'Sản phẩm có chính hãng không?',
                'answer' => "100% chính hãng!<br>
                             • Có tem bảo hành điện tử<br>
                             • Hóa đơn VAT đầy đủ<br>
                             • Kích hoạt bảo hành tại hãng",
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'category' => 'product',
                'question' => 'Làm sao biết sản phẩm còn hàng?',
                'answer' => "• Nút <strong>Thêm vào giỏ</strong>: Còn hàng<br>
                             • Nút <strong>Hết hàng</strong>: Tạm hết<br>
                             • Đăng ký thông báo → Nhận email khi có hàng",
                'sort_order' => 2,
                'is_active' => true,
            ],

            // === HỖ TRỢ KHÁC ===
            [
                'category' => 'support',
                'question' => 'Làm sao để liên hệ hỗ trợ?',
                'answer' => "• Hotline: <strong>1900 1000</strong> (8h-21h)<br>
                             • Zalo: <strong>0901 234 567</strong><br>
                             • Email: <strong>support@techshop.vn</strong><br>
                             • Chat trực tuyến: Góc dưới bên phải",
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'category' => 'support',
                'question' => 'Thời gian phản hồi email?',
                'answer' => "Trong vòng <strong>24h</strong> (trừ CN, lễ)<br>
                             Ưu tiên: Zalo → Hotline → Email",
                'sort_order' => 2,
                'is_active' => true,
            ],
        ];

        // XÓA DỮ LIỆU CŨ (nếu cần)
        // Faq::truncate();

        foreach ($faqs as $faq) {
            Faq::updateOrCreate(
                ['category' => $faq['category'], 'question' => $faq['question']],
                $faq
            );
        }

        $this->command->info('Đã thêm 20+ FAQ thành công!');
    }
}
