
<?php $__env->startSection('modal-title','Zonas del Area de Produccion: '.$productionArea->name); ?>
<?php $__env->startSection('modal-content'); ?>
    <form class="" role="form"  id="productionArea-zones-form">
        <?php echo csrf_field(); ?>
        <div class="row">
            <div class="col-lg-12">
                <div class="form-group">
                    <label class="form-label">Zonas </label>
                    <div class="col-sm-12 ">
                        <div class="form-group">
                            <?php $__currentLoopData = $zones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $zone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($productionArea->inZone($zone->id)): ?>
                                    <label class="custom-control custom-checkbox">
                                        <input type="checkbox" checked="checked" class="custom-control-input" value="<?php echo e($zone->id); ?>" name="zones[]">
                                        <span class="custom-control-label"><?php echo e($zone->name); ?></span>
                                    </label>
                                <?php else: ?>
                                    <label class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" value="<?php echo e($zone->id); ?>" name="zones[]">
                                        <span class="custom-control-label"><?php echo e($zone->name); ?></span>
                                    </label>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('modal-validation'); ?>
    <?php echo makeValidation('#productionArea-zones-form','/productionArea/zones/'.$productionArea->id, "closeModal();"); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('components.modals.form-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/erm/resources/views/client/production-area/zones.blade.php ENDPATH**/ ?>