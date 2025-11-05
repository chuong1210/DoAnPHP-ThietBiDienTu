@extends('admin.layouts.admin')

@section('title', 'Thống kê doanh thu')

@section('content')
    <div class="container-fluid">
        <h4 class="fw-bold mb-4">Revenue Report</h4>

        {{-- Các thẻ tổng quan --}}
        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h6 class="text-muted">Revenue</h6>
                        <h3 class="fw-bold text-primary">
                            {{ number_format($thisMonthRevenue, 2) }} USD
                            <small class="fs-6 text-success"><i class="fa fa-arrow-up"></i> +15%</small>
                        </h3>
                        <div class="progress mt-2" style="height: 6px;">
                            <div class="progress-bar bg-primary" style="width: 45%;"></div>
                        </div>
                        <small class="text-muted">This month</small>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h6 class="text-muted">Profit</h6>
                        <h3 class="fw-bold text-success">
                            {{ number_format($thisMonthProfit, 2) }} USD
                            <small class="fs-6 text-success"><i class="fa fa-arrow-up"></i> +9%</small>
                        </h3>
                        <div class="progress mt-2" style="height: 6px;">
                            <div class="progress-bar bg-success" style="width: 35%;"></div>
                        </div>
                        <small class="text-muted">This month</small>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h6 class="text-muted">Orders</h6>
                        <h3 class="fw-bold text-warning">
                            {{ $thisMonthOrders }}
                            <small class="fs-6 text-success"><i class="fa fa-arrow-up"></i> +12%</small>
                        </h3>
                        <div class="progress mt-2" style="height: 6px;">
                            <div class="progress-bar bg-warning" style="width: 25%;"></div>
                        </div>
                        <small class="text-muted">This month</small>
                    </div>
                </div>
            </div>
        </div>

        {{-- Biểu đồ thống kê --}}
        <div class="row g-4">
            <div class="col-md-6">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <h6 class="fw-bold mb-0">Revenue by year</h6>
                        <form method="GET" class="mb-0">
                            <select name="year" class="form-select form-select-sm" onchange="this.form.submit()">
                                @for ($y = now()->year; $y >= now()->year - 3; $y--)
                                    <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                                @endfor
                            </select>
                        </form>
                    </div>
                    <div class="card-body">
                        <div id="chartRevenue"></div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <h6 class="fw-bold mb-0">Profit by year</h6>
                        <form method="GET" class="mb-0">
                            <select name="year" class="form-select form-select-sm" onchange="this.form.submit()">
                                @for ($y = now()->year; $y >= now()->year - 3; $y--)
                                    <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                                @endfor
                            </select>
                        </form>
                    </div>
                    <div class="card-body">
                        <div id="chartProfit"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    {{-- ApexCharts CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Dữ liệu từ controller
            const months = @json($months);
            const revenueData = @json($revenueData);
            const profitData = @json($profitData);

            // Biểu đồ doanh thu (line chart)
            const optionsRevenue = {
                chart: { type: 'area', height: 300, toolbar: { show: false } },
                series: [{ name: 'Revenue (USD)', data: revenueData }],
                xaxis: { categories: months, labels: { rotate: -45 } },
                colors: ['#3b82f6'],
                fill: { type: 'gradient', gradient: { shadeIntensity: 0.4, opacityFrom: 0.6, opacityTo: 0.1 } },
                dataLabels: { enabled: false },
                stroke: { curve: 'smooth', width: 3 },
            };
            new ApexCharts(document.querySelector("#chartRevenue"), optionsRevenue).render();

            // Biểu đồ lợi nhuận (bar chart)
            const optionsProfit = {
                chart: { type: 'bar', height: 300, toolbar: { show: false } },
                series: [{ name: 'Profit (USD)', data: profitData }],
                xaxis: { categories: months, labels: { rotate: -45 } },
                colors: ['#a855f7'],
                plotOptions: { bar: { columnWidth: '45%', borderRadius: 5 } },
                dataLabels: { enabled: false },
            };
            new ApexCharts(document.querySelector("#chartProfit"), optionsProfit).render();
        });
    </script>
@endsection