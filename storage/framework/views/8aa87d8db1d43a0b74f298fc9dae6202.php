
<?php $__env->startSection('title', ucfirst(auth()->user()->role) . ' Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <h4><i class="bi bi-speedometer2 me-2"></i>Dashboard</h4>
    <small class="text-muted">Welcome back, <?php echo e(auth()->user()->full_name); ?>!</small>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card stat-card blue p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-muted small">Available Resources</div>
                    <div class="fs-4 fw-bold"><?php echo e(\App\Models\EResource::count()); ?></div>
                </div>
                <i class="bi bi-journals fs-2 text-primary opacity-50"></i>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card stat-card green p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-muted small">My Total Accesses</div>
                    <div class="fs-4 fw-bold"><?php echo e(auth()->user()->accessLogs()->count()); ?></div>
                </div>
                <i class="bi bi-clock-history fs-2 text-success opacity-50"></i>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card stat-card orange p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-muted small">Categories</div>
                    <div class="fs-4 fw-bold"><?php echo e(\App\Models\Category::count()); ?></div>
                </div>
                <i class="bi bi-tag fs-2 text-warning opacity-50"></i>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    
    <div class="col-md-7">
        <div class="card p-3">
            <h6 class="fw-bold mb-3"><i class="bi bi-clock-history me-2 text-primary"></i>My Recent Accesses</h6>
            <?php $myLogs = auth()->user()->accessLogs()->with('eResource')->latest('accessed_at')->take(6)->get(); ?>
            <?php if($myLogs->isEmpty()): ?>
                <p class="text-muted text-center py-3">You haven't accessed any resources yet.</p>
            <?php else: ?>
            <div class="table-responsive">
                <table class="table table-sm table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr><th>Resource</th><th>Type</th><th>When</th></tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $myLogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td class="text-truncate" style="max-width:200px;"><?php echo e($log->eResource->title); ?></td>
                            <td>
                                <span class="badge bg-<?php echo e($log->access_type === 'download' ? 'success' : 'secondary'); ?>">
                                    <?php echo e(ucfirst($log->access_type)); ?>

                                </span>
                            </td>
                            <td class="text-muted small"><?php echo e($log->accessed_at->diffForHumans()); ?></td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
            <?php endif; ?>
        </div>
    </div>

    
    <div class="col-md-5">
        <div class="card p-3">
            <h6 class="fw-bold mb-3"><i class="bi bi-lightning me-2 text-warning"></i>Quick Actions</h6>
            <div class="d-grid gap-2">
                <a href="<?php echo e(route('search.index')); ?>" class="btn btn-primary text-start">
                    <i class="bi bi-search me-2"></i>Browse & Search Resources
                </a>
                <a href="<?php echo e(route('search.index')); ?>?file_type=PDF" class="btn btn-outline-secondary text-start">
                    <i class="bi bi-file-earmark-pdf me-2"></i>Browse PDFs
                </a>
                <a href="<?php echo e(route('search.index')); ?>?file_type=ePub" class="btn btn-outline-secondary text-start">
                    <i class="bi bi-book me-2"></i>Browse ePubs
                </a>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Baby\Desktop\laravel\kandalayang-library\resources\views/dashboard/student.blade.php ENDPATH**/ ?>