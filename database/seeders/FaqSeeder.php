<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    public function run()
    {
        $faqs = [
            [
                'category' => 'Thanh toán',
                'question' => 'Làm thế nào để thanh toán?',
                'answer' => 'Bạn có thể thanh toán bằng COD, chuyển khoản ngân hàng hoặc ví MoMo.',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'category' => 'Giao hàng',
                'question' => 'Thời gian giao hàng bao lâu?',
                'answer' => 'Thường từ 2-5 ngày tùy khu vực, miễn phí cho đơn từ 500k.',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'category' => 'Đổi trả',
                'question' => 'Chính sách đổi trả như thế nào?',
                'answer' => 'Đổi trả trong 7 ngày nếu sản phẩm lỗi, không áp dụng nếu đã sử dụng.',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'category' => 'Tài khoản',
                'question' => 'Làm sao để theo dõi đơn hàng?',
                'answer' => 'Vào phần "Đơn hàng của tôi" trong tài khoản để xem chi tiết.',
                'sort_order' => 4,
                'is_active' => true,
            ],
        ];

        foreach ($faqs as $faq) {
            Faq::create($faq);
        }
    }
}
