<?php $__env->startComponent('mail::message'); ?>
# Wit.へのアカウント仮登録が完了しました
以下のリンクから本登録を完了させて下さい<br>
<?php $__env->startComponent('mail::button', ['url' => url('/register/verify/'.$token)]); ?>
Register
<?php echo $__env->renderComponent(); ?>

このリンクは約60分後に有効期限が切れます。<br>
期限が切れた場合、お手数ですがはじめからやり直して下さい。<br>

# 上記リンクをクリックできない場合は、以下の URL をあなたのウェブブラウザにコピーして貼り付けてください。
    <?php echo e(url('/register/verify/'.$token)); ?>



本メールにお心当たりのない方はお手数ですが破棄して下さい。<br>
<?php echo e(config('app.name')); ?>

<?php echo $__env->renderComponent(); ?><?php /**PATH /var/www/laravel/wit/resources/views/wit/Emails/subscribers.blade.php ENDPATH**/ ?>