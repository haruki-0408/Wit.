<?php $__env->startSection('content'); ?>
    <div class="container p-3" style="height: 100vh;">
        <div class="row justify-content-center h-100">
            <div class="col-md-8 h-100">
                <div class="card border-success">
                    <div class="card-header bg-success text-light">アカウント仮登録</div>

                    <div class="card-body">
                        <form method="post" action="/register/before">
                            <?php echo csrf_field(); ?>
                            <div class="row mb-3">
                                <label for="email" class="col-md-4 col-form-label text-md-end">メールアドレス</label>

                                <div class="col-md-6">
                                    <input id="email" type="email"
                                        class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="email"
                                        value="<?php echo e(old('email')); ?>" required autocomplete="email">

                                    <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span class="invalid-feedback" role="alert">
                                            <strong><?php echo e($message); ?></strong>
                                        </span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                                    <?php if(session('register_error_message')): ?>
                                        <span class="text-danger">
                                            <strong><?php echo e(session('register_error_message')); ?></strong>
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4 text-end">
                                    <button type="submit" class="btn btn-outline-success">
                                        Send
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card text-center" style="height:59%">
                    <div class="card-header text-muted" style="font-size:0.5em">
                        登録した時点で下記規約に同意したものと見なします。
                    </div>
                    <div class="card-body overflow-scroll text-start" style="font-size:0.6em;">
                        <?php $__env->startComponent('wit.terms'); ?>
                        <?php echo $__env->renderComponent(); ?>
                    </div>
                </div>

            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/laravel/wit/resources/views/auth/register.blade.php ENDPATH**/ ?>