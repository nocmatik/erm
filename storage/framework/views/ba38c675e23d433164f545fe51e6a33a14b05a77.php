<?php $__env->startSection('page-title','Log de Commandos ejecutados por usuarios'); ?>
<?php $__env->startSection('page-icon','database'); ?>

<?php $__env->startSection('page-content'); ?>
    <?php echo makeDefaultView(['Usuario','Email','Sub Zona','Dispositivo','Sensor','Address','grd_id','Orden ejecutada','Fecha','IP'],'command-log'); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app-navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/erm/resources/views/water-management/command/index.blade.php ENDPATH**/ ?>