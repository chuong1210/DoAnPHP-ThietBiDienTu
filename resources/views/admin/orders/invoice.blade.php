<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Hóa đơn {{ $order->order_number }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            color: #333;
        }

        .container {
            width: 100%;
            margin: 0 auto;
            padding: 20px;
        }

        .header,
        .footer {
            text-align: center;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
            color: #FF3B3F;
        }

        .header p {
            margin: 5px 0;
        }

        .invoice-details {
            margin: 20px 0;
        }

        .invoice-details table {
            width: 100%;
            border-collapse: collapse;
        }

        .invoice-details td {
            padding: 8px;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .items-table th,
        .items-table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        .items-table th {
            background-color: #f2f2f2;
        }

        .items-table .text-right {
            text-align: right;
        }

        .summary {
            margin-top: 20px;
            width: 50%;
            float: right;
        }

        .summary table {
            width: 100%;
        }

        .summary td {
            padding: 5px;
        }

        .summary .total {
            font-weight: bold;
            font-size: 1.2em;
            color: #FF3B3F;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>TECHSHOP</h1>
            <p>Địa chỉ: 123 Đường Công Nghệ, Quận Tech, TP. Hồ Chí Minh</p>
            <p>Điện thoại: 1900 1234 - Email: contact@techshop.com</p>
            <hr>
            <h2>HÓA ĐƠN BÁN HÀNG</h2>
        </div>

        <div class="invoice-details">
            <table>
                <tr>
                    <td style="width: 50%;">
                        <strong>Khách hàng:</strong> {{ $order->customer_name }}<br>
                        <strong>Điện thoại:</strong> {{ $order->customer_phone }}<br>
                        <strong>Địa chỉ:</strong> {{ $order->shipping_address }}
                    </td>
                    <td style="width: 50%; text-align: right;">
                        <strong>Mã hóa đơn:</strong> {{ $order->order_number }}<br>
                        <strong>Ngày đặt:</strong> {{ $order->created_at->format('d/m/Y') }}<br>
                        <strong>Phương thức TT:</strong> {{ strtoupper($order->payment_method) }}
                    </td>
                </tr>
            </table>
        </div>

        <table class="items-table">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Sản phẩm</th>
                    <th class="text-right">Số lượng</th>
                    <th class="text-right">Đơn giá</th>
                    <th class="text-right">Thành tiền</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->product_name }}</td>
                        <td class="text-right">{{ $item->quantity }}</td>
                        <td class="text-right">{{ number_format($item->price) }}đ</td>
                        <td class="text-right">{{ number_format($item->subtotal) }}đ</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="summary">
            <table>
                <tr>
                    <td>Tạm tính:</td>
                    <td class="text-right">{{ number_format($order->subtotal) }}đ</td>
                </tr>
                <tr>
                    <td>Phí vận chuyển:</td>
                    <td class="text-right">{{ number_format($order->shipping_fee) }}đ</td>
                </tr>
                <tr>
                    <td>Giảm giá:</td>
                    <td class="text-right">-{{ number_format($order->discount) }}đ</td>
                </tr>
                <tr class="total">
                    <td>TỔNG CỘNG:</td>
                    <td class="text-right">{{ number_format($order->total) }}đ</td>
                </tr>
            </table>
        </div>

        <div style="clear: both;"></div>

        <div class="footer" style="margin-top: 50px;">
            <p>Cảm ơn quý khách đã mua hàng!</p>
        </div>
    </div>
</body>

</html>