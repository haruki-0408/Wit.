<?php $__env->startSection('content'); ?>
    <div class="container p-3">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card border-primary">
                    <div class="card-header bg-primary text-light">メールアドレス変更</div>

                    <div class="card-body">
                        <form method="post" action="/home/profile/settings/changeEmail">
                            <?php echo csrf_field(); ?>
                            <div class="row mb-3">
                                <label for="email" class="col-md-4 col-form-label text-md-end">メールアドレス</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" name="email" class="form-control"
                                        value="<?php echo e(old('email')); ?>" required autocomplete="email">

                                    <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="text-danger">
                                            <strong><?php echo e($message); ?></strong>
                                        </div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4 text-end">
                                    <button type="submit" class="btn btn-outline-primary">
                                        Send
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/laravel/wit/resources/views/wit/Account/change-email.blade.php ENDPATH**/ ?>