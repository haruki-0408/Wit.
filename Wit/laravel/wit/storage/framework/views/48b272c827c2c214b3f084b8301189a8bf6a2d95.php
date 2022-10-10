<?php $__env->startComponent('mail::message'); ?>
# こんにちは
本メールは、あなたのWit. アカウントのメールアドレス変更リクエストを受け取ったためにお送りしています。<br>
<?php $__env->startComponent('mail::button', ['url' => url('/email/verify/'.$token)]); ?>
Change Email
<?php echo $__env->renderComponent(); ?>

上記メールアドレス変更リンクをクリックし、メールアドレスの変更登録を完了して下さい<br>

# 上記リンクをクリックできない場合は、以下の URL をあなたのウェブブラウザにコピーして貼り付けてください。
    <?php echo e(url('/email/verify/'.$token)); ?>



本メールにお心当たりのない方はお手数ですが破棄して下さい。<br>
<?php echo e(config('app.name')); ?>

<?php echo $__env->renderComponent(); ?><?php /**PATH /var/www/laravel/wit/resources/views/wit/Emails/changed-email.blade.php ENDPATH**/ ?>