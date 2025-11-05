<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'Trang Chủ'); ?> - Shop Điện Tử</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .product-card {
            transition: transform 0.2s;
            height: 100%;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .product-image {
            height: 200px;
            object-fit: cover;
        }

        .price-old {
            text-decoration: line-through;
            color: #999;
        }

        .category-sidebar {
            background: white;
            border-radius: 8px;
            padding: 20px;
        }

        .category-item {
            padding: 8px 0;
            border-bottom: 1px solid #eee;
        }

        .category-item:last-child {
            border-bottom: none;
        }

        .category-item a {
            color: #333;
            text-decoration: none;
        }

        .category-item a:hover {
            color: #007bff;
        }
    </style>

    <?php echo $__env->yieldContent('styles'); ?>
</head>

<body>
    <!-- Header -->
    <?php echo $__env->make('client.partials.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <!-- Main Content -->
    <main class="py-4">
        <div class="container-fluid">
            <div class="row">
                <!-- Sidebar Category (nếu có) -->
                <?php if(!isset($hideSidebar)): ?>
                    <div class="col-md-3">
                        <?php echo $__env->make('client.partials.sidebar-category', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    </div>
                    <div class="col-md-9">
                        <?php echo $__env->yieldContent('content'); ?>
                    </div>
                <?php else: ?>
                    <div class="col-md-12">
                        <?php echo $__env->yieldContent('content'); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <?php echo $__env->make('client.partials.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('client.partials.chat-widget', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <?php echo $__env->yieldContent('scripts'); ?>
</body>

</html>
<?php /**PATH C:\Users\chuon\PHP\doanPHP\resources\views/client/layouts/client.blade.php ENDPATH**/ ?>