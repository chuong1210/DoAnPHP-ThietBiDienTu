-- ==========================================
-- DATABASE ĐƠN GIẢN HÓA CHO SHOP ĐIỆN TỬ
-- Phiên bản tối ưu cho đồ án 1 tháng
-- ==========================================

CREATE DATABASE IF NOT EXISTS ShopOnlineDB CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE ShopOnlineDB;

-- ==========================================
-- 1. BẢNG USERS (Người dùng)
-- Quản lý admin và khách hàng
-- ==========================================
CREATE TABLE users (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    phone VARCHAR(15) NULL,
    role ENUM('admin','user') NOT NULL DEFAULT 'user',
    status ENUM('active','inactive') NOT NULL DEFAULT 'active',
    remember_token VARCHAR(100) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ==========================================
-- 2. BẢNG CATEGORIES (Danh mục sản phẩm)
-- Hỗ trợ danh mục cha-con
-- ==========================================
CREATE TABLE categories (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    slug VARCHAR(100) NOT NULL UNIQUE,
    parent_id BIGINT NULL,
    image VARCHAR(255) NULL,
    sort_order INT DEFAULT 0,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (parent_id) REFERENCES categories(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ==========================================
-- 3. BẢNG BRANDS (Thương hiệu)
-- ==========================================
CREATE TABLE brands (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL UNIQUE,
    slug VARCHAR(100) NOT NULL UNIQUE,
    logo VARCHAR(255) NULL,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ==========================================
-- 4. BẢNG PRODUCTS (Sản phẩm)
-- Bảng chính quản lý sản phẩm
-- ==========================================
CREATE TABLE products (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    category_id BIGINT NOT NULL,
    brand_id BIGINT NOT NULL,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    description TEXT NULL,
    price DECIMAL(12,2) NOT NULL,
    sale_price DECIMAL(12,2) NULL,
    quantity INT NOT NULL DEFAULT 0,
    image VARCHAR(255) NULL,
    images TEXT NULL COMMENT 'JSON array of images',
    status ENUM('active','inactive') DEFAULT 'active',
    is_featured BOOLEAN DEFAULT FALSE,
    view_count INT DEFAULT 0,
    sold_count INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE,
    FOREIGN KEY (brand_id) REFERENCES brands(id) ON DELETE CASCADE,
    INDEX idx_category (category_id),
    INDEX idx_brand (brand_id),
    INDEX idx_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ==========================================
-- 5. BẢNG CARTS (Giỏ hàng)
-- Mỗi user có 1 giỏ hàng
-- ==========================================
CREATE TABLE carts (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    user_id BIGINT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ==========================================
-- 6. BẢNG CART_ITEMS (Chi tiết giỏ hàng)
-- ==========================================
CREATE TABLE cart_items (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    cart_id BIGINT NOT NULL,
    product_id BIGINT NOT NULL,
    quantity INT NOT NULL DEFAULT 1,
    price DECIMAL(12,2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (cart_id) REFERENCES carts(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    UNIQUE KEY unique_cart_product (cart_id, product_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ==========================================
-- 7. BẢNG ORDERS (Đơn hàng)
-- ==========================================
CREATE TABLE orders (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    order_number VARCHAR(50) NOT NULL UNIQUE,
    user_id BIGINT NOT NULL,
    customer_name VARCHAR(100) NOT NULL,
    customer_phone VARCHAR(15) NOT NULL,
    customer_email VARCHAR(100) NULL,
    shipping_address TEXT NOT NULL,
    subtotal DECIMAL(12,2) NOT NULL,
    shipping_fee DECIMAL(12,2) DEFAULT 0,
    discount DECIMAL(12,2) DEFAULT 0,
    total DECIMAL(12,2) NOT NULL,
    payment_method ENUM('cod','bank_transfer','momo') NOT NULL DEFAULT 'cod',
    payment_status ENUM('pending','paid','failed') DEFAULT 'pending',
    status ENUM('pending','confirmed','shipping','delivered','cancelled') DEFAULT 'pending',
    note TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_user (user_id),
    INDEX idx_status (status),
    INDEX idx_order_number (order_number)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ==========================================
-- 8. BẢNG ORDER_ITEMS (Chi tiết đơn hàng)
-- ==========================================
CREATE TABLE order_items (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    order_id BIGINT NOT NULL,
    product_id BIGINT NOT NULL,
    product_name VARCHAR(255) NOT NULL,
    product_image VARCHAR(255) NULL,
    price DECIMAL(12,2) NOT NULL,
    quantity INT NOT NULL,
    subtotal DECIMAL(12,2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ==========================================
-- 9. BẢNG REVIEWS (Đánh giá sản phẩm)
-- ==========================================
CREATE TABLE reviews (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    product_id BIGINT NOT NULL,
    user_id BIGINT NOT NULL,
    order_id BIGINT NULL,
    rating TINYINT NOT NULL CHECK(rating BETWEEN 1 AND 5),
    comment TEXT NULL,
    status ENUM('pending','approved','rejected') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ==========================================
-- 10. BẢNG BANNERS (Banner quảng cáo)
-- ==========================================
CREATE TABLE banners (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    image VARCHAR(255) NOT NULL,
    link VARCHAR(255) NULL,
    sort_order INT DEFAULT 0,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ==========================================
-- 11. BẢNG COUPONS (Mã giảm giá)
-- ==========================================
CREATE TABLE coupons (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    code VARCHAR(50) NOT NULL UNIQUE,
    type ENUM('fixed','percent') NOT NULL,
    value DECIMAL(12,2) NOT NULL,
    min_order DECIMAL(12,2) DEFAULT 0,
    max_discount DECIMAL(12,2) DEFAULT NULL,
    max_uses INT NULL,
    used_count INT DEFAULT 0,
    start_date TIMESTAMP NULL,
    end_date TIMESTAMP NULL,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ==========================================
-- 12. BẢNG CONTACTS (Liên hệ hỗ trợ)
-- ==========================================
CREATE TABLE contacts (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(15) NULL,
    subject VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    status ENUM('new','replied','closed') DEFAULT 'new',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
-- ==========================================
-- 13. BẢNG FAQS (Câu hỏi thường gặp)
-- ==========================================
CREATE TABLE faqs (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    category VARCHAR(100) NULL COMMENT 'Phân loại (ví dụ: Thanh toán, Giao hàng)',
    question VARCHAR(500) NOT NULL,
    answer TEXT NOT NULL,
    sort_order INT DEFAULT 0,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_category (category),
    INDEX idx_active (is_active),
    INDEX idx_sort (sort_order)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- ==========================================
--13. BẢNG CHAT_ROOMS (Phòng chat)
-- Mỗi phòng là 1 cuộc trò chuyện giữa user và admin
-- ==========================================
CREATE TABLE chat_rooms (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    user_id BIGINT NOT NULL,
    admin_id BIGINT NULL COMMENT 'ID admin tham gia chat',
    subject VARCHAR(255) NULL COMMENT 'Tiêu đề chat (tự động tạo)',
    status ENUM('open','closed') DEFAULT 'open',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_user (user_id),
    INDEX idx_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
-- Sample data cho FAQ
INSERT INTO faqs (category, question, answer, sort_order) VALUES
('Thanh toán', 'Làm thế nào để thanh toán?', 'Bạn có thể thanh toán bằng COD, chuyển khoản ngân hàng hoặc ví MoMo.', 1),
('Giao hàng', 'Thời gian giao hàng bao lâu?', 'Thường từ 2-5 ngày tùy khu vực, miễn phí cho đơn từ 500k.', 2),
('Đổi trả', 'Chính sách đổi trả như thế nào?', 'Đổi trả trong 7 ngày nếu sản phẩm lỗi, không áp dụng nếu đã sử dụng.', 3),
('Tài khoản', 'Làm sao để theo dõi đơn hàng?', 'Vào phần "Đơn hàng của tôi" trong tài khoản để xem chi tiết.', 4);
-- ==========================================
--14. BẢNG CHAT_MESSAGES (Tin nhắn chat)
-- ==========================================
CREATE TABLE chat_messages (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    room_id BIGINT NOT NULL,
    user_id BIGINT NOT NULL,
    message TEXT NOT NULL,
    message_type ENUM('text','image') DEFAULT 'text',
    is_admin BOOLEAN DEFAULT FALSE COMMENT 'TRUE nếu từ admin',
    is_read BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (room_id) REFERENCES chat_rooms(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_room (room_id),
    INDEX idx_user (user_id),
    INDEX idx_is_read (is_read)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- ==========================================
-- INDEX ĐỂ TỐI ƯU TÌM KIẾM
-- ==========================================
-- Tìm kiếm sản phẩm
ALTER TABLE products ADD FULLTEXT INDEX idx_search (name, description);

-- ==========================================
-- SAMPLE DATA (Dữ liệu mẫu để test)
-- ==========================================

-- Admin user (password: admin123)
INSERT INTO users (email, password, full_name, phone, role) VALUES
('admin@shop.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Admin', '0901234567', 'admin');

-- Sample users (password: user123)
INSERT INTO users (email, password, full_name, phone, role) VALUES
('user1@gmail.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Nguyễn Văn A', '0912345678', 'user'),
('user2@gmail.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Trần Thị B', '0923456789', 'user');

-- Categories
INSERT INTO categories (name, slug, parent_id, sort_order) VALUES
('Điện thoại', 'dien-thoai', NULL, 1),
('Laptop', 'laptop', NULL, 2),
('Tablet', 'tablet', NULL, 3),
('Phụ kiện', 'phu-kien', NULL, 4),
('Tai nghe', 'tai-nghe', 4, 1),
('Sạc dự phòng', 'sac-du-phong', 4, 2);

-- Brands
INSERT INTO brands (name, slug) VALUES
('Apple', 'apple'),
('Samsung', 'samsung'),
('Xiaomi', 'xiaomi'),
('OPPO', 'oppo'),
('Dell', 'dell'),
('HP', 'hp'),
('Asus', 'asus');

-- Sample Products
INSERT INTO products (category_id, brand_id, name, slug, description, price, sale_price, quantity, is_featured) VALUES
(1, 1, 'iPhone 15 Pro Max 256GB', 'iphone-15-pro-max-256gb', 'iPhone 15 Pro Max với chip A17 Pro mạnh mẽ', 29990000, 28990000, 50, TRUE),
(1, 2, 'Samsung Galaxy S24 Ultra', 'samsung-galaxy-s24-ultra', 'Galaxy S24 Ultra với bút S-Pen tích hợp', 26990000, 25990000, 30, TRUE),
(2, 5, 'Dell XPS 13 Plus', 'dell-xps-13-plus', 'Laptop Dell XPS 13 Plus siêu mỏng nhẹ', 35990000, NULL, 20, FALSE),
(2, 6, 'HP Pavilion 15', 'hp-pavilion-15', 'Laptop HP Pavilion 15 cho văn phòng', 15990000, 14990000, 40, FALSE),
(3, 1, 'iPad Pro 12.9 M2', 'ipad-pro-12-9-m2', 'iPad Pro với chip M2 cực mạnh', 28990000, NULL, 15, TRUE);

-- Sample Banners
INSERT INTO banners (title, image, link, sort_order) VALUES
('Sale 50% Điện thoại', 'banner1.jpg', '/products?sale=true', 1),
('Laptop giảm giá', 'banner2.jpg', '/category/laptop', 2),
('Ra mắt iPhone 15', 'banner3.jpg', '/products/iphone-15-pro-max', 3);

-- Sample Coupons
INSERT INTO coupons (code, type, value, min_order, max_discount, max_uses, start_date, end_date) VALUES
('WELCOME10', 'percent', 10, 500000, NULL, 100, NOW(), DATE_ADD(NOW(), INTERVAL 30 DAY)),
('FREESHIP', 'fixed', 30000, 300000, NULL, 200, NOW(), DATE_ADD(NOW(), INTERVAL 60 DAY)),
('SALE50K', 'fixed', 50000, 1000000, NULL, 50, NOW(), DATE_ADD(NOW(), INTERVAL 15 DAY));
