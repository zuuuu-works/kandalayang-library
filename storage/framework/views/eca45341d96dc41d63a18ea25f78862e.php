
<?php $__env->startSection('title', 'Manage Publishers'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h4><i class="bi bi-building me-2"></i>Publishers</h4>
        <small class="text-muted">Manage all publishers in the system</small>
    </div>
    <a href="<?php echo e(route('publishers.create')); ?>" class="btn btn-primary btn-sm">
        <i class="bi bi-plus-circle me-1"></i> Add Publisher
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Website</th>
                    <th>Address</th>
                    <th class="text-center">E-Resources</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $publishers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $publisher): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td class="text-muted small"><?php echo e($publisher->id); ?></td>
                    <td class="fw-semibold"><?php echo e($publisher->name); ?></td>
                    <td class="small text-muted"><?php echo e($publisher->email ?? '—'); ?></td>
                    <td class="small">
                        <?php if($publisher->website): ?>
                            <a href="<?php echo e($publisher->website); ?>" target="_blank" class="text-decoration-none">
                                <i class="bi bi-box-arrow-up-right me-1"></i>Visit
                            </a>
                        <?php else: ?>
                            <span class="text-muted">—</span>
                        <?php endif; ?>
                    </td>
                    <td class="small text-muted" style="max-width:180px;">
                        <div class="text-truncate"><?php echo e($publisher->address ?? '—'); ?></div>
                    </td>
                    <td class="text-center">
                        <span class="badge bg-primary rounded-pill"><?php echo e($publisher->e_resources_count); ?></span>
                    </td>
                    <td class="text-center">
                        <a href="<?php echo e(route('publishers.edit', $publisher)); ?>" class="btn btn-sm btn-outline-primary" title="Edit">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form method="POST" action="<?php echo e(route('publishers.destroy', $publisher)); ?>" class="d-inline"
                              onsubmit="return confirm('Delete this publisher?')">
                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                            <button class="btn btn-sm btn-outline-danger" title="Delete">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="7" class="text-center py-4 text-muted">
                        <i class="bi bi-inbox fs-3 d-block mb-2"></i>No publishers yet.
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php if($publishers->hasPages()): ?>
    <div class="card-footer"><?php echo e($publishers->links()); ?></div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Baby\Desktop\laravel\kandalayang-library\resources\views/publishers/index.blade.php ENDPATH**/ ?>