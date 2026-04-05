
<?php $__env->startSection('title', 'Manage Users'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <h4><i class="bi bi-people me-2"></i>Users</h4>
    <small class="text-muted">Manage registered system users</small>
</div>


<div class="card p-3 mb-3">
    <form method="GET" action="<?php echo e(route('users.index')); ?>" class="row g-2 align-items-end">
        <div class="col-md-4">
            <input type="text" name="search" class="form-control" placeholder="Search by name or email..."
                   value="<?php echo e(request('search')); ?>">
        </div>
        <div class="col-md-2">
            <select name="role" class="form-select">
                <option value="">All Roles</option>
                <?php $__currentLoopData = ['librarian','student','faculty','researcher']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($role); ?>" <?php echo e(request('role') === $role ? 'selected' : ''); ?>>
                        <?php echo e(ucfirst($role)); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="col-md-2">
            <select name="status" class="form-select">
                <option value="">All Status</option>
                <option value="active"   <?php echo e(request('status') === 'active'   ? 'selected' : ''); ?>>Active</option>
                <option value="inactive" <?php echo e(request('status') === 'inactive' ? 'selected' : ''); ?>>Inactive</option>
            </select>
        </div>
        <div class="col-md-2 d-flex gap-2">
            <button type="submit" class="btn btn-primary w-100">Search</button>
            <a href="<?php echo e(route('users.index')); ?>" class="btn btn-outline-secondary"><i class="bi bi-x-lg"></i></a>
        </div>
    </form>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Registered</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td class="text-muted small"><?php echo e($user->id); ?></td>
                    <td class="fw-semibold"><?php echo e($user->full_name); ?></td>
                    <td class="small text-muted"><?php echo e($user->email); ?></td>
                    <td>
                        <span class="badge rounded-pill
                            bg-<?php echo e($user->role === 'librarian' ? 'dark' : ($user->role === 'faculty' ? 'info text-dark' : ($user->role === 'researcher' ? 'warning text-dark' : 'secondary'))); ?>">
                            <?php echo e(ucfirst($user->role)); ?>

                        </span>
                    </td>
                    <td>
                        <span class="badge bg-<?php echo e($user->status === 'active' ? 'success' : 'danger'); ?>">
                            <?php echo e(ucfirst($user->status)); ?>

                        </span>
                    </td>
                    <td class="small text-muted"><?php echo e($user->created_at->format('M d, Y')); ?></td>
                    <td class="text-center">
                        <a href="<?php echo e(route('users.show', $user)); ?>" class="btn btn-sm btn-outline-secondary" title="View">
                            <i class="bi bi-eye"></i>
                        </a>
                        <a href="<?php echo e(route('users.edit', $user)); ?>" class="btn btn-sm btn-outline-primary" title="Edit">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <?php if($user->status === 'active'): ?>
                            <form method="POST" action="<?php echo e(route('users.deactivate', $user)); ?>" class="d-inline">
                                <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                                <button class="btn btn-sm btn-outline-danger" title="Deactivate">
                                    <i class="bi bi-person-x"></i>
                                </button>
                            </form>
                        <?php else: ?>
                            <form method="POST" action="<?php echo e(route('users.activate', $user)); ?>" class="d-inline">
                                <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                                <button class="btn btn-sm btn-outline-success" title="Activate">
                                    <i class="bi bi-person-check"></i>
                                </button>
                            </form>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="7" class="text-center py-4 text-muted">
                        <i class="bi bi-inbox fs-3 d-block mb-2"></i>No users found.
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php if($users->hasPages()): ?>
    <div class="card-footer"><?php echo e($users->links()); ?></div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Baby\Desktop\laravel\kandalayang-library\resources\views/users/index.blade.php ENDPATH**/ ?>