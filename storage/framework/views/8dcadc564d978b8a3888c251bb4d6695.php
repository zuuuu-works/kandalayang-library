
<?php $__env->startSection('title', 'Manage E-Resources'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h4><i class="bi bi-journals me-2"></i>E-Resources</h4>
        <small class="text-muted">Manage the library's digital collection</small>
    </div>
    <a href="<?php echo e(route('e-resources.create')); ?>" class="btn btn-primary btn-sm">
        <i class="bi bi-plus-circle me-1"></i> Add E-Resource
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Author</th>
                        <th>Publisher</th>
                        <th>Type</th>
                        <th>Year</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $eResources; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $resource): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td class="text-muted small"><?php echo e($resource->id); ?></td>
                        <td class="fw-semibold" style="max-width:200px;">
                            <div class="text-truncate"><?php echo e($resource->title); ?></div>
                        </td>
                        <td><span class="badge bg-light text-dark border"><?php echo e($resource->category->name); ?></span></td>
                        <td class="small"><?php echo e($resource->author->full_name); ?></td>
                        <td class="small text-muted"><?php echo e($resource->publisher->name); ?></td>
                        <td><span class="badge bg-primary"><?php echo e($resource->file_type ?? '—'); ?></span></td>
                        <td class="small text-muted"><?php echo e($resource->publication_year ?? '—'); ?></td>
                        <td class="text-center">
                            <a href="<?php echo e(route('e-resources.show', $resource)); ?>" class="btn btn-sm btn-outline-secondary" title="View">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="<?php echo e(route('e-resources.edit', $resource)); ?>" class="btn btn-sm btn-outline-primary" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form method="POST" action="<?php echo e(route('e-resources.destroy', $resource)); ?>" class="d-inline"
                                  onsubmit="return confirm('Delete this resource?')">
                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                <button class="btn btn-sm btn-outline-danger" title="Delete">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="8" class="text-center py-4 text-muted">
                            <i class="bi bi-inbox fs-3 d-block mb-2"></i>No e-resources found.
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php if($eResources->hasPages()): ?>
    <div class="card-footer"><?php echo e($eResources->links()); ?></div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Baby\Desktop\laravel\kandalayang-library\resources\views/e-resources/index.blade.php ENDPATH**/ ?>