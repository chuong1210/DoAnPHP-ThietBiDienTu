@component('mail::message')
# Cảm ơn bạn đã đặt hàng!

Chúc mừng **{{ $order->customer_name }}**!
Đơn hàng của bạn đã được tiếp nhận thành công.

@component('mail::table')
| Sản phẩm | SL | Giá | Thành tiền |
|----------|----|-----|------------|
@foreach($order->items as $item)
    | {{ $item->product_name }} | {{ $item->quantity }} | {{ number_format($item->price) }}đ |
    **{{ number_format($item->price * $item->quantity) }}đ** |
@endforeach
@endcomponent

@component('mail::panel')
**Tổng cộng:** {{ number_format($order->total) }}đ
**Phí ship:** {{ number_format($order->shipping_fee) }}đ
@if($order->discount > 0)
    **Giảm giá:** -{{ number_format($order->discount) }}đ
@endif
@endcomponent

@component('mail::button', ['url' => route('client.my-orders.show', $order->id)])
Xem chi tiết đơn hàng
@endcomponent

Cảm ơn bạn đã tin tưởng **{{ config('app.name') }}**!
Nếu có thắc mắc, vui lòng liên hệ: **support@yourshop.com**

Trân trọng,
**{{ config('app.name') }} Team**
@endcomponent