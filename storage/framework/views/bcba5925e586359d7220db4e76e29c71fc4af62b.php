<?php $__env->startSection('page-title'); ?>
    Resumen Energía
<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-icon','bolt'); ?>
<?php $__env->startSection('page-content'); ?>
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-pills justify-content-end" role="tablist">
                        <li class="nav-item">
                            <div class="form-group mr-3">
                                <select name="sub_zone_id" id="sub_zone_id" class="form-control">
                                    <option value="">Todas las Sub zonas</option>
                                    <?php $__currentLoopData = $sub_zones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sub_zone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($sub_zone); ?>"><?php echo e($sub_zone); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </li>
                        <li class="nav-item" id="sensor_list_dropdown">
                            <a class="form-control border " href="javascript:void(0);" data-toggle="dropdown">Meses <i class="fal fa-chevron-down"></i></a>
                            <ul class="dropdown-menu " style="max-height: 300px; overflow-y: auto;">
                                <?php $__currentLoopData = $months; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $month): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li class="list-group-item">
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input sensors" value="<?php echo e($month); ?>" checked name="months">
                                            <span class="custom-control-label"><?php echo e($month); ?></span>
                                        </label>
                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </li>


                    </ul>

                    <div class="row">
                        <div class="col" id="chartContainer"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('more-scripts'); ?>
    <?php echo includeScript([
		   'plugins/highcharts/highcharts.js',
		   'plugins/highcharts/modules/exporting.js',
	   ]); ?>

    <?php echo $__env->make('water-management.dashboard.energy.chart.chart', ['zone_id' => $zone->id], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <script>
        function getFilters()
        {
            return {
                months : $.map($('input[name="months"]:checked'), function(c){return c.value; }),
                sub_zone : $('#sub_zone_id').val()
            };
        }

        $('#sub_zone_id').on('change',function() {
            renderChart();
        })

        $('input[name="months"]').on('click',function() {
            renderChart();
        });
        renderChart();
    </script>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-extra-scripts'); ?>
    <?php echo includeScript('plugins/bootstrap-daterangepicker/daterangepicker.js'); ?>


<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app-blank', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/erm/resources/views/water-management/dashboard/energy/resume-chart.blade.php ENDPATH**/ ?>