
<?php $__env->startSection('title', 'Access Logs'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <h4><i class="bi bi-clock-history me-2"></i>Access Logs</h4>
    <small class="text-muted">Detailed record of every resource access</small>
</div>


<div class="card p-3 mb-3">
    <form method="GET" action="<?php echo e(route('reports.access-logs')); ?>" class="row g-2 align-items-end">
        <div class="col-md-3">
            <label class="form-label small fw-semibold">User</label>
            <select name="user_id" class="form-select form-select-sm">
                <option value="">All Users</option>
                <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($user->id); ?>" <?php echo e(request('user_id') == $user->id ? 'selected' : ''); ?>>
                        <?php echo e($user->full_name); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label small fw-semibold">E-Resource</label>
            <select name="e_resource_id" class="form-select form-select-sm">
                <option value="">All Resources</option>
                <?php $__currentLoopData = $eResources; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $res): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($res->id); ?>" <?php echo e(request('e_resource_id') == $res->id ? 'selected' : ''); ?>>
                        <?php echo e(Str::limit($res->title, 40)); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="col-md-2">
            <label class="form-label small fw-semibold">Access Type</label>
            <select name="access_type" class="form-select form-select-sm">
                <option value="">All Types</option>
                <option value="view"     <?php echo e(request('access_type') === 'view'     ? 'selected' : ''); ?>>View</option>
                <option value="download" <?php echo e(request('access_type') === 'download' ? 'selected' : ''); ?>>Download</option>
                <option value="stream"   <?php echo e(request('access_type') === 'stream'   ? 'selected' : ''); ?>>Stream</option>
            </select>
        </div>
        <div class="col-md-2">
            <label class="form-label small fw-semibold">Date From</label>
            <input type="date" name="date_from" class="form-control form-control-sm" value="<?php echo e(request('date_from')); ?>">
        </div>
        <div class="col-md-1">
            <label class="form-label small fw-semibold">To</label>
            <input type="date" name="date_to" class="form-control form-control-sm" value="<?php echo e(request('date_to')); ?>">
        </div>
        <div class="col-md-1 d-flex gap-1">
            <button type="submit" class="btn btn-sm btn-primary w-100">Go</button>
            <a href="<?php echo e(route('reports.access-logs')); ?>" class="btn btn-sm btn-outline-secondary"><i class="bi bi-x"></i></a>
        </div>
    </form>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>User</th>
                    <th>Role</th>
                    <th>E-Resource</th>
                    <th>Access Type</th>
                    <th>Accessed At</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $logs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td class="text-muted small"><?php echo e($log->id); ?></td>
                    <td class="fw-semibold small"><?php echo e($log->user->full_name); ?></td>
                    <td>
                        <span class="badge bg-secondary" style="font-size:0.65rem;"><?php echo e($log->user->role); ?></span>
                    </td>
                    <td class="small text-truncate" style="max-width:200px;"><?php echo e($log->eResource->title); ?></td>
                    <td>
                        <span class="badge bg-<?php echo e($log->access_type === 'download' ? 'success' : ($log->access_type === 'stream' ? 'warning text-dark' : 'secondary')); ?>">
                            <?php echo e(ucfirst($log->access_type)); ?>

                        </span>
                    </td>
                    <td class="small text-muted"><?php echo e($log->accessed_at->format('M d, Y h:i A')); ?></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="6" class="text-center py-4 text-muted">
                        <i class="bi bi-inbox fs-3 d-block mb-2"></i>No access logs found.
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php if($logs->hasPages()): ?>
    <div class="card-footer"><?php echo e($logs->links()); ?></div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Baby\Desktop\laravel\kandalayang-library\resources\views/reports/access-logs.blade.php ENDPATH**/ ?>