ユーザからのお問い合わせがありました。<br>
----以下内容です---<br>
【名前】:<?php echo e($name); ?><br>
【メールアドレス】:<?php echo e($email); ?><br>
【ユーザ作成日時】:<?php echo e($created_at); ?><br>
【お問い合わせ日時】:<?php echo e(\Carbon\Carbon::now()); ?><br>
【お問い合わせ内容】:<?php echo e($inquiry_sentence); ?><br><?php /**PATH /var/www/laravel/wit/resources/views/wit/Emails/inquiry.blade.php ENDPATH**/ ?>