    <ul class="Tags-List m-0">
        <?php $__currentLoopData = $tags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li><button class="tag" type="button"><span class="tag-name"><?php echo e($tag->name); ?></span><span class="tag-number badge badge-light"><?php echo e($tag->number); ?></span></button></li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>





<?php /**PATH /var/www/laravel/wit/resources/views/wit/tags.blade.php ENDPATH**/ ?>