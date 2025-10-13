import requests
import json
import time
from pathlib import Path
import re
from datetime import datetime
import os
from urllib.parse import urlparse

class GearVNSQLGenerator:
    def __init__(self, base_path="C:\\Users\\chuon\\PHP\\doanPHP\\database\\data"):
        self.base_path = Path(base_path)
        self.images_path = self.base_path / "images"
        self.images_path.mkdir(exist_ok=True)  # Tạo thư mục images nếu chưa có

        self.session = requests.Session()
        self.session.headers.update({
            'User-Agent': 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36'
        })

        # Tracking để tránh trùng lặp
        self.category_map = {}  # handle -> id
        self.brand_map = {}     # name -> id
        self.product_ids = set()

        # Counter cho ID
        self.category_counter = 1
        self.brand_counter = 1
        self.product_counter = 1

        # SQL statements
        self.category_inserts = []
        self.brand_inserts = []
        self.product_inserts = []

        # Categories structure
        self.categories_config = {
            "Laptop": [
                "laptop-van-phong-ban-chay",
                "laptop-hoc-tap-va-lam-viec-duoi-15tr",
                "laptop-hoc-tap-va-lam-viec-tu-15tr-den-20tr",
                "laptop-hoc-tap-va-lam-viec-tren-20-trieu"
            ],
            "Laptop Gaming": [
                "laptop-gaming-ban-chay",
                "laptop-gaming-gia-tu-20-den-25-trieu",
                "laptop-gaming-gia-tu-25-den-35-trieu",
                "laptop-gaming-tren-35-trieu"
            ],
            "PC": [
                "pc-gvn-i3",
                "pc-gvn-i5",
                "pc-gvn-i7",
                "pc-gvn-i9"
            ],
            "Linh kiện": [
                "vga-rtx-50-series",
                "mainboard-bo-mach-chu",
                "cpu-amd-ryzen",
                "case-thung-may-tinh",
                "psu-nguon-may-tinh",
                "tan-nhiet-may-tinh"
            ],
            "Ổ cứng & RAM": [
                "ram-pc",
                "hdd-o-cung-pc",
                "ssd-o-cung-the-ran",
                "the-nho"
            ],
            "Thiết bị âm thanh": [
                "loa",
                "webcam"
            ],
            "Màn hình": [
                "collections-cho-landing-page-man-hinh-nhom-sp-1",
                "collections-cho-landing-page-man-hinh-nhom-sp-2",
                "man-hinh-oled"
            ],
            "Bàn phím & Chuột": [
                "ban-phim-may-tinh",
                "chuot-may-tinh",
                "mouse-pad"
            ],
            "Tai nghe": [
                "tai-nghe-may-tinh"
            ],
            "Gaming Gear": [
                "may-choi-game",
                "tay-cam-vo-lang",
                "sony-playstation"
            ],
            "Phụ kiện": [
                "phu-kien",
                "thiet-bi-mang",
                "ghe-gia-tot"
            ]
        }

    def clean_sql_string(self, text):
        """Làm sạch chuỗi cho SQL"""
        if text is None:
            return 'NULL'

        # Chuyển đổi sang string nếu không phải
        text = str(text)

        # Escape single quotes
        text = text.replace("'", "''")
        text = text.replace("\\", "\\\\")

        # Giới hạn độ dài
        if len(text) > 500:
            text = text[:497] + '...'

        return f"'{text}'"

    def create_slug(self, text):
        """Tạo slug từ text"""
        text = text.lower()
        # Chuyển đổi tiếng Việt sang không dấu
        vietnamese_map = {
            'à': 'a', 'á': 'a', 'ả': 'a', 'ã': 'a', 'ạ': 'a',
            'ă': 'a', 'ằ': 'a', 'ắ': 'a', 'ẳ': 'a', 'ẵ': 'a', 'ặ': 'a',
            'â': 'a', 'ầ': 'a', 'ấ': 'a', 'ẩ': 'a', 'ẫ': 'a', 'ậ': 'a',
            'đ': 'd',
            'è': 'e', 'é': 'e', 'ẻ': 'e', 'ẽ': 'e', 'ẹ': 'e',
            'ê': 'e', 'ề': 'e', 'ế': 'e', 'ể': 'e', 'ễ': 'e', 'ệ': 'e',
            'ì': 'i', 'í': 'i', 'ỉ': 'i', 'ĩ': 'i', 'ị': 'i',
            'ò': 'o', 'ó': 'o', 'ỏ': 'o', 'õ': 'o', 'ọ': 'o',
            'ô': 'o', 'ồ': 'o', 'ố': 'o', 'ổ': 'o', 'ỗ': 'o', 'ộ': 'o',
            'ơ': 'o', 'ờ': 'o', 'ớ': 'o', 'ở': 'o', 'ỡ': 'o', 'ợ': 'o',
            'ù': 'u', 'ú': 'u', 'ủ': 'u', 'ũ': 'u', 'ụ': 'u',
            'ư': 'u', 'ừ': 'u', 'ứ': 'u', 'ử': 'u', 'ữ': 'u', 'ự': 'u',
            'ỳ': 'y', 'ý': 'y', 'ỷ': 'y', 'ỹ': 'y', 'ỵ': 'y'
        }

        for viet, latin in vietnamese_map.items():
            text = text.replace(viet, latin)

        # Chỉ giữ chữ cái, số và dấu gạch ngang
        text = re.sub(r'[^a-z0-9]+', '-', text)
        text = text.strip('-')

        return text

    def download_image(self, image_url, product_id, is_main=False):
        """Tải ảnh về và lưu vào thư mục images, trả về đường dẫn tương đối"""
        if not image_url:
            return None

        try:
            # Lấy extension từ URL
            parsed_url = urlparse(image_url)
            ext = Path(parsed_url.path).suffix.lower()
            if not ext:
                ext = '.jpg'  # Mặc định

            if is_main:
                filename = f"product_{product_id}_main{ext}"
            else:
                filename = f"product_{product_id}_{hash(image_url) % 10000}{ext}"  # Hash để tránh trùng

            filepath = self.images_path / filename
            relative_path = f"images/{filename}"

            if filepath.exists():
                print(f"    Ảnh đã tồn tại: {filename}")
                return relative_path

            response = self.session.get(image_url, timeout=15)
            response.raise_for_status()

            with open(filepath, 'wb') as f:
                f.write(response.content)

            print(f"    Đã tải ảnh: {filename}")
            return relative_path

        except Exception as e:
            print(f"    Lỗi tải ảnh {image_url}: {str(e)}")
            return image_url  # Fallback to original URL if download fails

    def generate_categories_sql(self):
        """Tạo SQL cho categories"""
        print("Đang tạo SQL cho categories...")

        for parent_name, sub_handles in self.categories_config.items():
            # Tạo parent category
            parent_slug = self.create_slug(parent_name)
            parent_id = self.category_counter
            self.category_map[parent_slug] = parent_id

            sql = f"INSERT INTO categories (id, name, slug, parent_id, sort_order, is_active) VALUES ({parent_id}, {self.clean_sql_string(parent_name)}, {self.clean_sql_string(parent_slug)}, NULL, {self.category_counter}, TRUE);"
            self.category_inserts.append(sql)
            self.category_counter += 1

            # Tạo sub categories
            for sub_handle in sub_handles:
                sub_name = sub_handle.replace('-', ' ').title()
                sub_id = self.category_counter
                self.category_map[sub_handle] = sub_id

                sql = f"INSERT INTO categories (id, name, slug, parent_id, sort_order, is_active) VALUES ({sub_id}, {self.clean_sql_string(sub_name)}, {self.clean_sql_string(sub_handle)}, {parent_id}, {self.category_counter}, TRUE);"
                self.category_inserts.append(sql)
                self.category_counter += 1

        print(f"Đã tạo {len(self.category_inserts)} categories")

    def add_brand(self, brand_name):
        """Thêm brand và trả về ID"""
        if not brand_name or brand_name == 'NULL':
            brand_name = 'No Brand'

        brand_name = brand_name.strip()

        if brand_name in self.brand_map:
            return self.brand_map[brand_name]

        brand_id = self.brand_counter
        brand_slug = self.create_slug(brand_name)

        sql = f"INSERT INTO brands (id, name, slug, is_active) VALUES ({brand_id}, {self.clean_sql_string(brand_name)}, {self.clean_sql_string(brand_slug)}, TRUE);"
        self.brand_inserts.append(sql)

        self.brand_map[brand_name] = brand_id
        self.brand_counter += 1

        return brand_id

    def crawl_and_generate_products_sql(self, category_handle, limit=20):
        """Crawl sản phẩm và tạo SQL"""
        if category_handle not in self.category_map:
            print(f"  Bỏ qua {category_handle} - không có trong category map")
            return 0

        category_id = self.category_map[category_handle]
        api_url = f"https://gearvn.com/collections/{category_handle}/products.json"

        print(f"  Crawling: {category_handle}")

        products_added = 0
        page = 1
        max_pages = 3  # Giới hạn 3 trang để không quá nhiều sản phẩm

        while page <= max_pages and products_added < limit:
            try:
                url = f"{api_url}?page={page}&limit=12"
                response = self.session.get(url, timeout=15)
                response.raise_for_status()

                data = response.json()

                if isinstance(data, dict) and 'products' in data:
                    products = data['products']
                elif isinstance(data, list):
                    products = data
                else:
                    break

                if not products:
                    break

                for product in products:
                    if products_added >= limit:
                        break

                    try:
                        product_id_original = product.get('id')

                        # Skip nếu đã có
                        if product_id_original in self.product_ids:
                            continue

                        self.product_ids.add(product_id_original)

                        # Lấy thông tin sản phẩm
                        name = product.get('title', 'Unknown Product')
                        slug = product.get('handle', self.create_slug(name))
                        brand_name = product.get('vendor', 'No Brand')

                        # Thêm brand
                        brand_id = self.add_brand(brand_name)

                        # Lấy giá
                        variants = product.get('variants', [])
                        price = 0
                        sale_price = 0
                        quantity = 0

                        if variants:
                            first_variant = variants[0]
                            price = float(first_variant.get('price', 0)) / 100  # Chuyển từ cents
                            compare_price = first_variant.get('compare_at_price')
                            if compare_price:
                                sale_price = float(compare_price) / 100
                            quantity = first_variant.get('inventory_quantity', 0)

                        # Lấy ảnh và tải về, sử dụng đường dẫn tương đối hoặc URL gốc
                        main_image_path = None
                        images_paths = []

                        main_image = product.get('image')
                        main_image_url = main_image.get('src', '') if main_image else ''
                        if main_image_url:
                            main_image_path = self.download_image(main_image_url, self.product_counter, is_main=True)

                        product_images = product.get('images', [])
                        if product_images:
                            for img in product_images:
                                img_url = img.get('src', '')
                                if img_url and img_url != main_image_url:  # Bỏ qua ảnh chính nếu trùng
                                    img_path = self.download_image(img_url, self.product_counter)
                                    if img_path:
                                        images_paths.append(img_path)
                                if len(images_paths) >= 5:  # Tối đa 5 ảnh
                                    break

                            # Nếu không có ảnh phụ, thêm ảnh chính nếu có
                            if not images_paths and main_image_path:
                                images_paths.append(main_image_path)

                        # Nếu vẫn không có, dùng URL gốc cho images
                        if not images_paths and product_images:
                            img_urls = [img.get('src', '') for img in product_images[:5]]
                            images_paths = [url if isinstance(url, str) else url for url in img_urls]

                        images_json = self.clean_sql_string(json.dumps(images_paths[:5])) if images_paths else 'NULL'

                        # Mô tả (lấy từ body_html và làm sạch HTML)
                        description = product.get('body_html', '')
                        if description:
                            # Loại bỏ HTML tags
                            description = re.sub(r'<[^>]+>', '', description)
                            description = description[:500]  # Giới hạn độ dài

                        # Trạng thái
                        is_available = product.get('available', False)
                        status = 'active' if is_available else 'inactive'

                        # Featured (random một số sản phẩm)
                        is_featured = 'TRUE' if products_added % 5 == 0 else 'FALSE'

                        # Tạo SQL INSERT (sử dụng đường dẫn tương đối hoặc URL cho image)
                        if main_image_path:
                            image_sql = self.clean_sql_string(main_image_path)
                        else:
                            image_sql = self.clean_sql_string(main_image_url) if main_image_url else 'NULL'

                        sql = f"""INSERT INTO products (id, category_id, brand_id, name, slug, description, price, sale_price, quantity, image, images, status, is_featured, view_count, sold_count)
VALUES ({self.product_counter}, {category_id}, {brand_id}, {self.clean_sql_string(name)}, {self.clean_sql_string(slug)}, {self.clean_sql_string(description)}, {price}, {sale_price if sale_price > 0 else 'NULL'}, {max(0, quantity)}, {image_sql}, {images_json}, '{status}', {is_featured}, 0, 0);"""

                        self.product_inserts.append(sql)
                        self.product_counter += 1
                        products_added += 1

                        time.sleep(0.5)  # Delay nhỏ giữa các sản phẩm để tránh rate limit

                    except Exception as e:
                        print(f"    Lỗi xử lý sản phẩm: {str(e)}")
                        continue

                page += 1
                time.sleep(1)

            except Exception as e:
                print(f"    Lỗi crawl trang {page}: {str(e)}")
                break

        print(f"    Đã thêm {products_added} sản phẩm")
        return products_added

    def generate_all_sql(self):
        """Tạo tất cả SQL statements"""
        print("BẮT ĐẦU TẠO SQL CHO DATABASE")
        print("=" * 60)

        # 1. Tạo categories
        self.generate_categories_sql()
        print()

        # 2. Crawl products và tạo brands + products
        print("Đang crawl sản phẩm và tạo SQL...")
        total_products = 0

        for parent_name, sub_handles in self.categories_config.items():
            print(f"\n{parent_name}:")
            for sub_handle in sub_handles:
                products_count = self.crawl_and_generate_products_sql(sub_handle, limit=15)
                total_products += products_count
                time.sleep(1)

        print()
        print("=" * 60)
        print(f"Tổng kết:")
        print(f"- Categories: {len(self.category_inserts)}")
        print(f"- Brands: {len(self.brand_inserts)}")
        print(f"- Products: {len(self.product_inserts)}")
        print(f"- Images downloaded to: {self.images_path}")
        print(f"- Image paths in SQL: relative to current directory (e.g., 'images/product_1_main.jpg') or original URLs")
        print("=" * 60)

    def save_sql_file(self):
        """Lưu tất cả SQL vào file"""
        output_file = self.base_path / "gearvn_data_insert.sql"

        print(f"\nĐang lưu SQL vào file: {output_file}")

        try:
            with open(output_file, 'w', encoding='utf-8') as f:
                # Header
                f.write("-- ==========================================\n")
                f.write("-- GearVN Data Import SQL\n")
                f.write(f"-- Generated: {datetime.now().strftime('%Y-%m-%d %H:%M:%S')}\n")
                f.write("-- ==========================================\n\n")
                f.write("USE ShopOnlineDB;\n\n")
                f.write("SET FOREIGN_KEY_CHECKS=0;\n\n")

                # Xóa dữ liệu cũ
                f.write("-- Xóa dữ liệu cũ\n")
                f.write("TRUNCATE TABLE order_items;\n")
                f.write("TRUNCATE TABLE orders;\n")
                f.write("TRUNCATE TABLE cart_items;\n")
                f.write("TRUNCATE TABLE carts;\n")
                f.write("TRUNCATE TABLE reviews;\n")
                f.write("TRUNCATE TABLE products;\n")
                f.write("TRUNCATE TABLE brands;\n")
                f.write("TRUNCATE TABLE categories;\n\n")

                # Categories
                f.write("-- ==========================================\n")
                f.write("-- CATEGORIES\n")
                f.write("-- ==========================================\n")
                for sql in self.category_inserts:
                    f.write(sql + "\n")
                f.write("\n")

                # Brands
                f.write("-- ==========================================\n")
                f.write("-- BRANDS\n")
                f.write("-- ==========================================\n")
                for sql in self.brand_inserts:
                    f.write(sql + "\n")
                f.write("\n")

                # Products
                f.write("-- ==========================================\n")
                f.write("-- PRODUCTS\n")
                f.write("-- ==========================================\n")
                for sql in self.product_inserts:
                    f.write(sql + "\n")
                f.write("\n")

                # Footer
                f.write("SET FOREIGN_KEY_CHECKS=1;\n\n")
                f.write("-- ==========================================\n")
                f.write("-- THỐNG KÊ\n")
                f.write("-- ==========================================\n")
                f.write(f"-- Categories: {len(self.category_inserts)}\n")
                f.write(f"-- Brands: {len(self.brand_inserts)}\n")
                f.write(f"-- Products: {len(self.product_inserts)}\n")
                f.write(f"-- Images path: {self.images_path}\n")
                f.write("-- Image URLs in DB: relative paths like 'images/filename.jpg' or original remote URLs\n")
                f.write("-- ==========================================\n")

            print(f"✓ Đã lưu file SQL thành công!")
            print(f"✓ Đường dẫn: {output_file}")
            print(f"\nCách sử dụng:")
            print(f"1. Mở MySQL/phpMyAdmin")
            print(f"2. Chọn database ShopOnlineDB")
            print(f"3. Import file: {output_file.name}")
            print(f"4. Ảnh được lưu tại: {self.images_path}")
            print(f"5. Trong web app, configure để serve thư mục images từ URL hiện tại (e.g., /data/images/)")

        except Exception as e:
            print(f"✗ Lỗi khi lưu file: {str(e)}")

    def save_json_mapping(self):
        """Lưu mapping giữa GearVN ID và DB ID"""
        mapping_file = self.base_path / "gearvn_mapping.json"

        mapping_data = {
            'categories': {slug: id for slug, id in self.category_map.items()},
            'brands': {name: id for name, id in self.brand_map.items()},
            'total_products': len(self.product_inserts),
            'images_path': str(self.images_path),
            'image_url_base': 'images/',  # Relative URL base for local images
            'generated_at': datetime.now().strftime('%Y-%m-%d %H:%M:%S')
        }

        try:
            with open(mapping_file, 'w', encoding='utf-8') as f:
                json.dump(mapping_data, f, ensure_ascii=False, indent=2)
            print(f"✓ Đã lưu file mapping: {mapping_file.name}")
        except Exception as e:
            print(f"✗ Lỗi khi lưu mapping: {str(e)}")

def main():
    """Hàm chính"""
    print("GEARVN TO SQL GENERATOR")
    print("=" * 60)
    print("Script này sẽ crawl dữ liệu từ GearVN")
    print("tạo file SQL để import vào database ShopOnlineDB")
    print("và tải ảnh về thư mục images với đường dẫn tương đối trong SQL")
    print("=" * 60)
    print()

    generator = GearVNSQLGenerator()

    try:
        # Tạo tất cả SQL
        generator.generate_all_sql()

        # Lưu file
        generator.save_sql_file()
        generator.save_json_mapping()

        print("\n" + "=" * 60)
        print("HOÀN TẤT!")
        print(f"✓ SQL: {generator.base_path / 'gearvn_data_insert.sql'}")
        print(f"✓ Mapping: {generator.base_path / 'gearvn_mapping.json'}")
        print(f"✓ Images: {generator.images_path} (URLs in DB: relative 'images/...')")
        print("=" * 60)

    except KeyboardInterrupt:
        print("\n\nĐã dừng theo yêu cầu người dùng")
    except Exception as e:
        print(f"\nLỗi: {str(e)}")

if __name__ == "__main__":
    main()
