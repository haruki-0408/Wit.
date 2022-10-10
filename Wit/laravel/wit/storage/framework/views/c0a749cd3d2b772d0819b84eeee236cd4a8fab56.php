<?php $__env->startSection('content'); ?>
    <?php $__env->startComponent('wit.home-modals'); ?>
    <?php echo $__env->renderComponent(); ?>
    <div class="container p-3 overflow-auto" style="height:80%;">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card border-primary">
                    <div class="card-header bg-primary text-light">お問い合わせ</div>

                    <div class="card-body p-2">
                        <?php if(isset($inquiry_sentence)): ?>
                            <form method="post" action="/home/profile/inquiry/send">
                                <?php echo csrf_field(); ?>
                                <p id="Head-sentence" style="font-size:14px;">お問い合わせ内容はこちらでよろしいでしょうか</p>
                                <hr>
                                <p class="fw-bold pb-2">ご登録メールアドレス:<?php echo e($email); ?></p>
                                <textarea class="pt-2 w-100 d-flex justify-content-center" rows="7" name="inquiry_sentence" autocorrect="off" autocapitalize="off" readonly><?php echo e($inquiry_sentence); ?></textarea>
                                <p class="text-danger fw-bold pt-2">※ご質問の場合回答はご登録されているメールアドレス宛に返信されます。ご了承下さい</p>
                                <div class="text-end">
                                    <button type="button" onclick="history.back(-1);return false;" class="mt-3 btn btn-outline-primary">Back</button>
                                    <button type="submit" class="mt-3 btn btn-outline-primary">Send</button>
                                </div>
                            </form>
                        <?php else: ?>
                            <form method="post" action="/home/profile/inquiry/confirm">
                                <?php echo csrf_field(); ?>
                                <p id="Head-sentence" style="font-size:14px;">
                                    Wit.のご利用ありがとうございます。ご不明な点やご要望等ございましたらお気軽に下記フォームにて投稿ください。</p>
                                <textarea id="Inquiry" class="w-100 d-flex p-1 justify-content-center" rows="7" name="inquiry_sentence"
                                    autocorrect="off" autocapitalize="off" placeholder=""></textarea>
                                <?php $__errorArgs = ['inquiry_sentence'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="text-danger">
                                        <strong><?php echo e($message); ?></strong>
                                    </span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                <p class="text-danger fw-bold pt-2">※ご質問の場合回答はご登録されているメールアドレス宛に返信されます。ご了承下さい</p>
                                <div class="text-end">
                                    <button type="submit" class="mt-3 btn btn-outline-primary">Confirm</button>
                                </div>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>



<?php $__env->startComponent('wit.footer'); ?>
<?php echo $__env->renderComponent(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/laravel/wit/resources/views/wit/Account/inquiry-form.blade.php ENDPATH**/ ?>