<?php $__env->startComponent('mail::message'); ?>
# Cảm ơn bạn đã đặt hàng!

Chúc mừng **<?php echo new \Illuminate\Support\EncodedHtmlString($order->customer_name); ?>**!
Đơn hàng của bạn đã được tiếp nhận thành công.

<?php $__env->startComponent('mail::table'); ?>
| Sản phẩm | SL | Giá | Thành tiền |
|----------|----|-----|------------|
<?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    | <?php echo new \Illuminate\Support\EncodedHtmlString($item->product_name); ?> | <?php echo new \Illuminate\Support\EncodedHtmlString($item->quantity); ?> | <?php echo new \Illuminate\Support\EncodedHtmlString(number_format($item->price)); ?>đ |
    **<?php echo new \Illuminate\Support\EncodedHtmlString(number_format($item->price * $item->quantity)); ?>đ** |
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php echo $__env->renderComponent(); ?>

<?php $__env->startComponent('mail::panel'); ?>
**Tổng cộng:** <?php echo new \Illuminate\Support\EncodedHtmlString(number_format($order->total)); ?>đ
**Phí ship:** <?php echo new \Illuminate\Support\EncodedHtmlString(number_format($order->shipping_fee)); ?>đ
<?php if($order->discount > 0): ?>
    **Giảm giá:** -<?php echo new \Illuminate\Support\EncodedHtmlString(number_format($order->discount)); ?>đ
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>

<?php $__env->startComponent('mail::button', ['url' => route('client.my-orders.show', $order->id)]); ?>
Xem chi tiết đơn hàng
<?php echo $__env->renderComponent(); ?>

Cảm ơn bạn đã tin tưởng **<?php echo new \Illuminate\Support\EncodedHtmlString(config('app.name')); ?>**!
Nếu có thắc mắc, vui lòng liên hệ: **support@yourshop.com**

Trân trọng,
**<?php echo new \Illuminate\Support\EncodedHtmlString(config('app.name')); ?> Team**
<?php echo $__env->renderComponent(); ?><?php /**PATH C:\Users\chuon\PHP\doanPHP\resources\views/emails/orders/success.blade.php ENDPATH**/ ?>