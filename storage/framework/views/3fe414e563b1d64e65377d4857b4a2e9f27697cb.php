
<?php $__env->startSection('mail-header'); ?>
   Archivos Generados Correctamente!
<?php $__env->stopSection(); ?>
<?php $__env->startSection('mail-content'); ?>
    <p>
        <span style="font-size: 18px;">﻿</span>
        <span style="font-size: 18px;">﻿</span>
        <b>
            <span style="font-size: 12px;">
                <span style="font-size: 18px;"><?php echo e($user->full_name); ?></span>,
            </span>
        </b>
    </p>
    <p>Se han generado los archivos solicitados en <?php echo e($reminder->creation_date); ?></p>
    <p>Haga click en los siguientes enlaces para descargar:</p>
    <p>
        <?php $__currentLoopData = $files; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a href="https://erm.cmatik.app/download-file/<?php echo e($file->id); ?>" target="_blank"><?php echo e($file->display_name); ?></a><br>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </p>
    <p>
        <span style="font-size: 0.8125rem; letter-spacing: 0.1px;">Estos enlaces expiran en <?php echo e($reminder->expires_at); ?></span><br>
    </p>
    <p><br></p>
    <p>Saludos Cordiales</p>
    <p>ERM® CMATIK</p>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('emails.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/erm/resources/views/emails/files-created.blade.php ENDPATH**/ ?>