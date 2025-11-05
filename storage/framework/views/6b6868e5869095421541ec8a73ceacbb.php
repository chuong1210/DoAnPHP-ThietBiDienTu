<?php $__env->startSection('title', 'Dashboard'); ?>
<?php $__env->startSection('page-title', 'Bảng Điều Khiển'); ?>

<?php $__env->startSection('styles'); ?>
    <style>
        /* Filter Buttons */
        .filter-buttons .btn {
            background-color: var(--bg-white);
            border: 1px solid var(--border-color);
            color: var(--text-muted);
            font-weight: 600;
            transition: all 0.2s ease;
            padding: 8px 16px;
        }

        .filter-buttons .btn:hover {
            background-color: var(--bg-main);
            color: #0066FF;
        }

        .filter-buttons .btn.active {
            background: linear-gradient(135deg, #0066FF 0%, #00B4D8 100%);
            color: white;
            border-color: transparent;
            box-shadow: 0 4px 12px rgba(0, 102, 255, 0.3);
        }

        /* Stat Cards */
        .stat-card {
            background-color: var(--bg-white);
            border: 1px solid #CBD5E1;
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 25px rgba(0, 102, 255, 0.1);
            border-color: #00B4D8;
        }

        .stat-card h6 {
            color: #64748B;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 13px;
            margin-bottom: 8px;
        }

        .stat-card h3 {
            color: #1E293B;
            font-weight: 700;
            margin-bottom: 0;
        }

        .stat-change {
            font-weight: 600;
            font-size: 14px;
            padding: 4px 8px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .stat-change.positive {
            background-color: #d1fae5;
            color: #065f46;
        }

        .stat-change.negative {
            background-color: #fee2e2;
            color: #991b1b;
        }

        /* Chart Card Styling */
        .card {
            border: 1px solid #CBD5E1;
            box-shadow: 0 2px 8px rgba(30, 41, 59, 0.04);
        }

        .card-header {
            background-color: #F8FAFC;
            border-bottom: 1px solid #CBD5E1;
        }

        .card-header h5 {
            color: #1E293B;
            font-weight: 600;
        }

        /* Table Styling */
        .table thead th {
            background-color: #F8FAFC;
            color: #1E293B;
            font-size: 13px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 2px solid #CBD5E1;
        }

        .table .product-img {
            width: 45px;
            height: 45px;
            object-fit: cover;
            border-radius: 8px;
        }

        .table-hover tbody tr:hover {
            background-color: #F8FAFC !important;
        }

        /* Badge Trạng thái */
        .status-badge {
            font-size: 0.75rem;
            padding: 0.4em 0.8em;
            border-radius: 20px;
            font-weight: 600;
            text-transform: capitalize;
        }

        .status-badge-pending {
            background-color: #FEF3C7;
            color: #92400E;
        }

        .status-badge-confirmed {
            background-color: #DBEAFE;
            color: #1E40AF;
        }

        .status-badge-shipping {
            background-color: #D1FAE5;
            color: #065F46;
        }

        .status-badge-delivered {
            background-color: #E0E7FF;
            color: #3730A3;
        }

        .status-badge-cancelled {
            background-color: #FEE2E2;
            color: #991B1B;
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <!-- Header & Filters -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
        <h1 class="h3 mb-0" style="color: #1E293B;">Tổng Quan</h1>
        <div class="filter-buttons btn-group" role="group">
            <a href="<?php echo e(route('admin.dashboard', ['period' => 'today'])); ?>"
                class="btn <?php echo e($period == 'today' ? 'active' : ''); ?>">Hôm Nay</a>
            <a href="<?php echo e(route('admin.dashboard', ['period' => 'last_7_days'])); ?>"
                class="btn <?php echo e($period == 'last_7_days' ? 'active' : ''); ?>">7 Ngày</a>
            <a href="<?php echo e(route('admin.dashboard', ['period' => 'this_month'])); ?>"
                class="btn <?php echo e($period == 'this_month' ? 'active' : ''); ?>">Tháng Này</a>
            <a href="<?php echo e(route('admin.dashboard', ['period' => 'this_year'])); ?>"
                class="btn <?php echo e($period == 'this_year' ? 'active' : ''); ?>">Năm Nay</a>
        </div>
    </div>

    <!-- Stat Cards Row -->
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stat-card h-100">
                <div class="card-body">
                    <h6>Doanh Thu</h6>
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="mb-0"><?php echo e(number_format($stats['revenue'])); ?>đ</h3>
                        <span class="stat-change <?php echo e($stats['revenue_change'] >= 0 ? 'positive' : 'negative'); ?>">
                            <i class="fas fa-arrow-<?php echo e($stats['revenue_change'] >= 0 ? 'up' : 'down'); ?>"></i>
                            <span><?php echo e(number_format(abs($stats['revenue_change']), 1)); ?>%</span>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stat-card h-100">
                <div class="card-body">
                    <h6>Đơn Hàng</h6>
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="mb-0"><?php echo e(number_format($stats['orders'])); ?></h3>
                        <span class="stat-change <?php echo e($stats['orders_change'] >= 0 ? 'positive' : 'negative'); ?>">
                            <i class="fas fa-arrow-<?php echo e($stats['orders_change'] >= 0 ? 'up' : 'down'); ?>"></i>
                            <span><?php echo e(number_format(abs($stats['orders_change']), 1)); ?>%</span>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stat-card h-100">
                <div class="card-body">
                    <h6>Giá Trị Đơn Trung Bình</h6>
                    <h3 class="mb-0"><?php echo e(number_format($stats['avg_order_value'])); ?>đ</h3>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stat-card h-100">
                <div class="card-body">
                    <h6>Khách Hàng Mới</h6>
                    <h3 class="mb-0"><?php echo e(number_format($stats['new_users'])); ?></h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Chart Row -->
    <div class="row">
        <div class="col-lg-12 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0">Tổng Quan Doanh Thu</h5>
                </div>
                <div class="card-body">
                    <div id="revenueTimelineChart"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Secondary Charts Row -->
    <div class="row">
        <div class="col-lg-7 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0">Doanh Thu Theo Tháng (Năm <?php echo e(now()->year); ?>)</h5>
                </div>
                <div class="card-body">
                    <div id="monthlyRevenueChart"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-5 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0">Tỷ Lệ Trạng Thái Đơn Hàng</h5>
                </div>
                <div class="card-body d-flex align-items-center justify-content-center">
                    <div id="orderStatusChart" style="min-height: 350px; width: 100%;"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- New Analytics Row: Category & Customer Stats -->
    <div class="row">
        <div class="col-lg-6 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0">Doanh Thu Theo Danh Mục</h5>
                </div>
                <div class="card-body">
                    <div id="categoryRevenueChart"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0">Top 5 Khách Hàng Tiềm Năng</h5>
                </div>
                <div class="card-body">
                    <div id="topCustomersChart"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tables Row -->
    <div class="row">
        <!-- Recent Orders Table -->
        <div class="col-lg-7 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Đơn Hàng Mới Nhất</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>Mã ĐH</th>
                                    <th>Khách Hàng</th>
                                    <th>Tổng Tiền</th>
                                    <th class="text-center">Trạng Thái</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $recentOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td><a href="<?php echo e(route('admin.orders.show', $order->id)); ?>"
                                                class="fw-bold text-decoration-none" style="color: #0066FF;"><?php echo e($order->order_number); ?></a></td>
                                        <td><?php echo e($order->customer_name); ?></td>
                                        <td><?php echo e(number_format($order->total)); ?>đ</td>
                                        <td class="text-center">
                                            <span
                                                class="status-badge status-badge-<?php echo e($order->status); ?>"><?php echo e($order->status); ?></span>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="4" class="text-center p-4">Không có đơn hàng nào trong khoảng thời gian
                                            này.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Top Products Table -->
        <div class="col-lg-5 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Sản Phẩm Bán Chạy</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>Sản Phẩm</th>
                                    <th class="text-center">Đã Bán</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $topProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="<?php echo e(asset($product->image ?? 'https://static.vecteezy.com/system/resources/previews/016/916/479/original/placeholder-icon-design-free-vector.jpg')); ?>"
                                                    alt="<?php echo e($product->name); ?>" class="product-img me-3">
                                                <div>
                                                    <a href="<?php echo e(route('admin.products.edit', $product->id)); ?>"
                                                        class="fw-bold d-block text-decoration-none" style="color: #1E293B;"><?php echo e(Str::limit($product->name, 30)); ?></a>
                                                    <small class="text-muted"><?php echo e(number_format($product->price)); ?>đ</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge rounded-pill fs-6" style="background: #0066FF; color: white;"><?php echo e($product->sold_count); ?></span>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="2" class="text-center p-4">Chưa có dữ liệu bán hàng.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <script>
        const formatNumber = (num) => {
            if (num >= 1000000) {
                return (num / 1000000).toFixed(1).replace(/\.0$/, '') + 'tr';
            }
            if (num >= 1000) {
                return (num / 1000).toFixed(0) + 'k';
            }
            return num;
        };

        document.addEventListener("DOMContentLoaded", function () {
            // === Chart Helpers ===
            const formatCurrency = (val) => new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(val);
            const chartPrimaryColor = '#0066FF';
            const chartSecondaryColor = '#00B4D8';
            const chartTextColor = '#64748B';
            const chartBorderColor = '#CBD5E1';

            // === 1. Revenue Timeline Chart ===
            var revenueTimelineOptions = {
                series: [{ name: 'Doanh thu', data: <?php echo json_encode($revenueTimelineChart['data'] ?? [], 15, 512) ?> }],
                chart: { type: 'area', height: 350, toolbar: { show: false }, zoom: { enabled: false } },
                dataLabels: { enabled: false },
                stroke: { curve: 'smooth', width: 3, colors: [chartPrimaryColor] },
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.6,
                        opacityTo: 0.1,
                        stops: [0, 90, 100],
                        colorStops: [
                            { offset: 0, color: chartPrimaryColor, opacity: 0.6 },
                            { offset: 100, color: chartSecondaryColor, opacity: 0.1 }
                        ]
                    }
                },
                xaxis: {
                    categories: <?php echo json_encode($revenueTimelineChart['labels'] ?? [], 15, 512) ?>,
                    labels: { style: { colors: chartTextColor } },
                    tooltip: { enabled: false }
                },
                yaxis: {
                    labels: {
                        style: { colors: chartTextColor },
                        formatter: (val) => formatNumber(val)
                    }
                },
                tooltip: { y: { formatter: (val) => formatCurrency(val) } },
                grid: { borderColor: chartBorderColor, strokeDashArray: 3 }
            };
            var revenueTimelineChart = new ApexCharts(document.querySelector("#revenueTimelineChart"), revenueTimelineOptions);
            revenueTimelineChart.render();

            // === 2. Monthly Revenue Chart ===
            var monthlyRevenueOptions = {
                series: [{ name: 'Doanh thu', data: <?php echo json_encode($monthlyChartData['data'] ?? [], 15, 512) ?> }],
                chart: { type: 'bar', height: 350, toolbar: { show: false } },
                plotOptions: {
                    bar: {
                        borderRadius: 8,
                        horizontal: false,
                        columnWidth: '55%',
                        dataLabels: { position: 'top' }
                    }
                },
                dataLabels: {
                    enabled: true,
                    formatter: (val) => formatNumber(val),
                    offsetY: -20,
                    style: { fontSize: '12px', colors: ["#1E293B"], fontWeight: 600 }
                },
                stroke: { show: true, width: 2, colors: ['transparent'] },
                colors: [chartPrimaryColor],
                xaxis: {
                    categories: <?php echo json_encode($monthlyChartData['labels'] ?? [], 15, 512) ?>,
                    labels: { style: { colors: chartTextColor } }
                },
                yaxis: { labels: { show: false } },
                fill: { opacity: 1 },
                tooltip: { y: { formatter: (val) => formatCurrency(val) } },
                grid: { borderColor: chartBorderColor, strokeDashArray: 3 }
            };
            var monthlyRevenueChart = new ApexCharts(document.querySelector("#monthlyRevenueChart"), monthlyRevenueOptions);
            monthlyRevenueChart.render();

            // === 3. Order Status Donut Chart ===
            const statusLabelsRaw = <?php echo json_encode(array_keys($orderStatusStats) ?? [], 15, 512) ?>;
            const statusData = <?php echo json_encode(array_values($orderStatusStats) ?? [], 15, 512) ?>;
            const statusConfig = {
                pending: { label: 'Chờ xử lý', color: '#F59E0B' },
                confirmed: { label: 'Đã xác nhận', color: '#3B82F6' },
                shipping: { label: 'Đang giao', color: '#10B981' },
                delivered: { label: 'Đã giao', color: '#6366F1' },
                cancelled: { label: 'Đã hủy', color: '#EF4444' }
            };
            const statusLabels = statusLabelsRaw.map(l => statusConfig[l]?.label || l);
            const statusColors = statusLabelsRaw.map(l => statusConfig[l]?.color || '#94A3B8');

            var orderStatusOptions = {
                series: statusData,
                chart: { type: 'donut', height: 350 },
                labels: statusLabels,
                colors: statusColors,
                legend: { position: 'bottom', horizontalAlign: 'center', offsetY: 5, fontWeight: 500 },
                dataLabels: { enabled: true, formatter: (val, opts) => opts.w.globals.series[opts.seriesIndex] },
                plotOptions: {
                    pie: {
                        donut: {
                            size: '65%',
                            labels: {
                                show: true,
                                total: {
                                    show: true,
                                    label: 'Tổng Đơn',
                                    fontSize: '20px',
                                    fontWeight: 600,
                                    color: '#1E293B',
                                    formatter: (w) => w.globals.seriesTotals.reduce((a, b) => a + b, 0)
                                }
                            }
                        }
                    }
                },
                responsive: [{ breakpoint: 480, options: { chart: { width: 300 }, legend: { position: 'bottom' } } }]
            };
            var orderStatusChart = new ApexCharts(document.querySelector("#orderStatusChart"), orderStatusOptions);
            orderStatusChart.render();

            // === 4. Category Revenue Chart (Horizontal Bar) ===
            const categoryRevenue = <?php echo json_encode($categoryRevenueData ?? [], 15, 512) ?>;
            const categoryLabels = categoryRevenue.map(item => item.category_name);
            const categoryValues = categoryRevenue.map(item => parseFloat(item.total_revenue));

            var categoryRevenueOptions = {
                series: [{ name: 'Doanh thu', data: categoryValues }],
                chart: { type: 'bar', height: 350, toolbar: { show: false } },
                plotOptions: {
                    bar: {
                        horizontal: true,
                        borderRadius: 8,
                        barHeight: '70%',
                        distributed: true,
                        dataLabels: { position: 'top' }
                    }
                },
                dataLabels: {
                    enabled: true,
                    formatter: (val) => formatNumber(val),
                    offsetX: 30,
                    style: { fontSize: '12px', colors: ['#1E293B'], fontWeight: 600 }
                },
                colors: ['#0066FF', '#00B4D8', '#1E90FF', '#4169E1', '#6495ED'],
                xaxis: {
                    categories: categoryLabels,
                    labels: { show: false }
                },
                yaxis: {
                    labels: {
                        style: { colors: '#1E293B', fontSize: '13px', fontWeight: 500 }
                    }
                },
                grid: { borderColor: '#CBD5E1', strokeDashArray: 3, xaxis: { lines: { show: true } } },
                tooltip: {
                    y: { formatter: (val) => formatCurrency(val) },
                    theme: 'light'
                },
                legend: { show: false }
            };
            var categoryRevenueChart = new ApexCharts(document.querySelector("#categoryRevenueChart"), categoryRevenueOptions);
            categoryRevenueChart.render();

            // === 5. Top Customers Chart (Radial Bar) ===
            const topCustomers = <?php echo json_encode($topCustomersData ?? [], 15, 512) ?>;
            const customerNames = topCustomers.map(c => c.customer_name.split(' ').slice(-2).join(' ')); // Lấy 2 từ cuối
            const customerValues = topCustomers.map(c => parseFloat(c.total_spent));
            const maxCustomerValue = Math.max(...customerValues);
            const customerPercentages = customerValues.map(val => Math.round((val / maxCustomerValue) * 100));

            var topCustomersOptions = {
                series: customerPercentages,
                chart: { type: 'radialBar', height: 380 },
                plotOptions: {
                    radialBar: {
                        offsetY: 0,
                        startAngle: 0,
                        endAngle: 270,
                        hollow: {
                            margin: 5,
                            size: '30%',
                            background: 'transparent',
                        },
                        dataLabels: {
                            name: {
                                show: true,
                                fontSize: '13px',
                                fontWeight: 600,
                                color: '#1E293B',
                                offsetY: -5
                            },
                            value: {
                                show: true,
                                fontSize: '16px',
                                fontWeight: 700,
                                color: '#0066FF',
                                offsetY: 5,
                                formatter: function(val, opts) {
                                    return formatNumber(customerValues[opts.seriesIndex]);
                                }
                            },
                            total: {
                                show: true,
                                label: 'Tổng',
                                fontSize: '14px',
                                fontWeight: 600,
                                color: '#64748B',
                                formatter: function (w) {
                                    const total = customerValues.reduce((a, b) => a + b, 0);
                                    return formatNumber(total);
                                }
                            }
                        },
                        track: {
                            background: '#F8FAFC',
                            strokeWidth: '100%',
                            margin: 8,
                        }
                    }
                },
                colors: ['#0066FF', '#00B4D8', '#1E90FF', '#4169E1', '#6495ED'],
                labels: customerNames,
                legend: {
                    show: true,
                    position: 'bottom',
                    offsetY: 5,
                    fontSize: '13px',
                    fontWeight: 500,
                    markers: { width: 12, height: 12, radius: 12 },
                    formatter: function(seriesName, opts) {
                        return seriesName + ' - ' + formatCurrency(customerValues[opts.seriesIndex]);
                    }
                },
                responsive: [{
                    breakpoint: 480,
                    options: {
                        legend: { show: false }
                    }
                }]
            };
            var topCustomersChart = new ApexCharts(document.querySelector("#topCustomersChart"), topCustomersOptions);
            topCustomersChart.render();
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\chuon\PHP\doanPHP\resources\views/admin/dashboard/index.blade.php ENDPATH**/ ?>