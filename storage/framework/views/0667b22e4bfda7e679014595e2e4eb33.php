
<?php $__env->startSection('title', 'View User'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h4><i class="bi bi-person-circle me-2"></i>User Details</h4>
        <small class="text-muted">Viewing profile of <?php echo e($user->full_name); ?></small>
    </div>
    <div class="d-flex gap-2">
        <a href="<?php echo e(route('users.edit', $user)); ?>" class="btn btn-sm btn-outline-primary">
            <i class="bi bi-pencil me-1"></i> Edit
        </a>
        <a href="<?php echo e(route('users.index')); ?>" class="btn btn-sm btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Back
        </a>
    </div>
</div>

<div class="row g-3">
    
    <div class="col-md-4">
        <div class="card p-4 text-center mb-3">
            <div class="mb-3">
                <div style="width:80px;height:80px;border-radius:50%;background:#1a3c5e;display:flex;align-items:center;justify-content:center;margin:0 auto;">
                    <span style="font-size:2rem;color:white;font-weight:700;">
                        <?php echo e(strtoupper(substr($user->first_name, 0, 1))); ?><?php echo e(strtoupper(substr($user->last_name, 0, 1))); ?>

                    </span>
                </div>
            </div>
            <h5 class="fw-bold mb-1"><?php echo e($user->full_name); ?></h5>
            <p class="text-muted small mb-2"><?php echo e($user->email); ?></p>
            <div class="d-flex justify-content-center gap-2 mb-3">
                <span class="badge rounded-pill
                    bg-<?php echo e($user->role === 'librarian' ? 'dark' : ($user->role === 'faculty' ? 'info text-dark' : ($user->role === 'researcher' ? 'warning text-dark' : 'secondary'))); ?>">
                    <?php echo e(ucfirst($user->role)); ?>

                </span>
                <span class="badge bg-<?php echo e($user->status === 'active' ? 'success' : 'danger'); ?>">
                    <?php echo e(ucfirst($user->status)); ?>

                </span>
            </div>
            <div class="text-muted small">Registered <?php echo e($user->created_at->format('M d, Y')); ?></div>
        </div>

        
        <div class="card p-3">
            <h6 class="fw-bold mb-3"><i class="bi bi-lightning me-2 text-warning"></i>Quick Actions</h6>
            <div class="d-grid gap-2">
                <a href="<?php echo e(route('users.edit', $user)); ?>" class="btn btn-outline-primary btn-sm text-start">
                    <i class="bi bi-pencil me-2"></i>Edit User
                </a>
                <?php if($user->status === 'active'): ?>
                    <form method="POST" action="<?php echo e(route('users.deactivate', $user)); ?>">
                        <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                        <button class="btn btn-outline-danger btn-sm w-100 text-start"
                                onclick="return confirm('Deactivate this user?')">
                            <i class="bi bi-person-x me-2"></i>Deactivate Account
                        </button>
                    </form>
                <?php else: ?>
                    <form method="POST" action="<?php echo e(route('users.activate', $user)); ?>">
                        <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                        <button class="btn btn-outline-success btn-sm w-100 text-start">
                            <i class="bi bi-person-check me-2"></i>Activate Account
                        </button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>

    
    <div class="col-md-8">
        <div class="card p-3">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-bold mb-0">
                    <i class="bi bi-clock-history me-2 text-primary"></i>
                    Access History
                    <span class="badge bg-primary rounded-pill ms-1"><?php echo e($user->accessLogs->count()); ?></span>
                </h6>
                <a href="<?php echo e(route('reports.access-logs', ['user_id' => $user->id])); ?>"
                   class="btn btn-sm btn-outline-secondary">
                    View All in Reports
                </a>
            </div>

            <?php if($user->accessLogs->isEmpty()): ?>
                <div class="text-center py-4 text-muted">
                    <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                    This user hasn't accessed any resources yet.
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-sm table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>E-Resource</th>
                                <th>Type</th>
                                <th>Category</th>
                                <th>Accessed At</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $user->accessLogs->sortByDesc('accessed_at')->take(15); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td class="small fw-semibold text-truncate" style="max-width:200px;">
                                    <?php echo e($log->eResource->title ?? '—'); ?>

                                </td>
                                <td>
                                    <span class="badge bg-<?php echo e($log->access_type === 'download' ? 'success' : ($log->access_type === 'stream' ? 'warning text-dark' : 'secondary')); ?>">
                                        <?php echo e(ucfirst($log->access_type)); ?>

                                    </span>
                                </td>
                                <td class="small text-muted">
                                    <?php echo e($log->eResource->category->name ?? '—'); ?>

                                </td>
                                <td class="small text-muted">
                                    <?php echo e(\Carbon\Carbon::parse($log->accessed_at)->format('M d, Y h:i A')); ?>

                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>

                <?php if($user->accessLogs->count() > 15): ?>
                    <div class="text-center mt-2">
                        <small class="text-muted">Showing 15 of <?php echo e($user->accessLogs->count()); ?> records.
                            <a href="<?php echo e(route('reports.access-logs', ['user_id' => $user->id])); ?>">View all</a>
                        </small>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Baby\Desktop\laravel\kandalayang-library\resources\views/users/show.blade.php ENDPATH**/ ?>