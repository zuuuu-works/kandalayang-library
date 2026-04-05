
<?php $__env->startSection('title', 'Manage Authors'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h4><i class="bi bi-person-lines-fill me-2"></i>Authors</h4>
        <small class="text-muted">Manage all authors in the system</small>
    </div>
    <a href="<?php echo e(route('authors.create')); ?>" class="btn btn-primary btn-sm">
        <i class="bi bi-plus-circle me-1"></i> Add Author
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Bio</th>
                    <th class="text-center">E-Resources</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $authors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $author): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td class="text-muted small"><?php echo e($author->id); ?></td>
                    <td class="fw-semibold"><?php echo e($author->full_name); ?></td>
                    <td class="small text-muted"><?php echo e($author->email ?? '—'); ?></td>
                    <td class="small text-muted" style="max-width:200px;">
                        <div class="text-truncate"><?php echo e($author->bio ?? '—'); ?></div>
                    </td>
                    <td class="text-center">
                        <span class="badge bg-primary rounded-pill"><?php echo e($author->e_resources_count); ?></span>
                    </td>
                    <td class="text-center">
                        <a href="<?php echo e(route('authors.edit', $author)); ?>" class="btn btn-sm btn-outline-primary" title="Edit">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form method="POST" action="<?php echo e(route('authors.destroy', $author)); ?>" class="d-inline"
                              onsubmit="return confirm('Delete this author?')">
                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                            <button class="btn btn-sm btn-outline-danger" title="Delete">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="6" class="text-center py-4 text-muted">
                        <i class="bi bi-inbox fs-3 d-block mb-2"></i>No authors yet.
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php if($authors->hasPages()): ?>
    <div class="card-footer"><?php echo e($authors->links()); ?></div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Baby\Desktop\laravel\kandalayang-library\resources\views/authors/index.blade.php ENDPATH**/ ?>