<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Banner;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $banners = [
            [
                'title' => 'Back to School 25 Slider',
                'image' => 'https://file.hstatic.net/200000722513/file/gearvn-back-to-school-25-slider.png',
                'link' => '#',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'Laptop Gaming Slider',
                'image' => 'https://file.hstatic.net/200000722513/file/gearvn-laptop-gaming-slider-bot-t8.png',
                'link' => '#',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'Bàn Phím Slider',
                'image' => 'https://file.hstatic.net/200000722513/file/gearvn-ban-phim-slider-right-t8.png',
                'link' => '#',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'title' => 'Gaming Gear Deal',
                'image' => 'https://file.hstatic.net/200000722513/file/gearvn-gaming-gear-deal-hoi-header-t8-pc.png',
                'link' => '#',
                'sort_order' => 4,
                'is_active' => true,
            ],
            [
                'title' => 'Collections June Banner',
                'image' => 'https://file.hstatic.net/200000722513/file/thang_06_banner_collections_1920x420_-_web_header.png',
                'link' => '#',
                'sort_order' => 5,
                'is_active' => true,
            ],
        ];

        foreach ($banners as $banner) {
            Banner::create($banner);
        }
    }
}
