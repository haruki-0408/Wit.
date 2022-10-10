<?php if( Session::has('sent')): ?>
<div>
    <p><?php echo e(old('name')); ?>さん、<?php echo e(session('sent')); ?></p>
</div>
<?php endif; ?>

<form action="/contact" method="post">
    <?php echo csrf_field(); ?>

    <p>名前：<input type="text" name="name"></p>

    <input type="submit" value="送信">
</form><?php /**PATH /var/www/laravel/wit/resources/views/wit/Emails/contact.blade.php ENDPATH**/ ?>