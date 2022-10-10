<?php $__env->startSection('content'); ?>
    <div class="container p-3">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card border-primary">
                    <div class="card-header bg-primary text-light">メールアドレス変更通知送信完了</div>

                    <div class="card-body">
                        <p>この度は、Wit.をご利用いただき、誠にありがとうございます。</p>
                        <p>
                            入力頂いたメールアドレスにアドレス変更用リンクを送信致しました。
                        </p>
                        <p>
                            そちらに記載されているURLにアクセスし、新しいメールアドレスの有効化を完了させてください。
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/laravel/wit/resources/views/wit/Account/send-change-email.blade.php ENDPATH**/ ?>