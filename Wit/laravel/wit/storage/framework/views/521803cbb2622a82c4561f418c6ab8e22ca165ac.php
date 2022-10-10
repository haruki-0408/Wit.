<?php $__env->startComponent('mail::message'); ?>
# こんにちは
本メールは、あなたのWit. アカウントのパスワードリセットリクエストを受け取ったためにお送りしています。<br>
<?php $__env->startComponent('mail::button', ['url' => $url]); ?>
Reset Password
<?php echo $__env->renderComponent(); ?>

このパスワードリセットリンクは <?php echo e($count); ?>分後に有効期限が切れます。<br>
期限が切れた場合、お手数ですがはじめからやり直して下さい。<br>

# 上記リンクをクリックできない場合は、以下の URL をあなたのウェブブラウザにコピーして貼り付けてください。
    <?php echo e(url($url)); ?>



本メールにお心当たりのない方はお手数ですが破棄して下さい。<br>
<?php echo e(config('app.name')); ?>

<?php echo $__env->renderComponent(); ?><?php /**PATH /var/www/laravel/wit/resources/views/wit/Emails/reset-password-mail.blade.php ENDPATH**/ ?>