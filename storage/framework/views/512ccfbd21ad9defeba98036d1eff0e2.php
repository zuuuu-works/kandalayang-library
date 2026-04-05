
<?php $__env->startSection('title', 'Search E-Resources'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <h4><i class="bi bi-search me-2"></i>Search E-Resources</h4>
    <small class="text-muted">Browse and access the library's digital collection</small>
</div>


<div class="card p-3 mb-4">
    <form method="GET" action="<?php echo e(route('search.index')); ?>" class="row g-2 align-items-end">
        <div class="col-md-4">
            <label class="form-label fw-semibold small">Keyword</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-search"></i></span>
                <input type="text" name="keyword" class="form-control" placeholder="Title, description, ISBN..."
                       value="<?php echo e(request('keyword')); ?>">
            </div>
        </div>
        <div class="col-md-3">
            <label class="form-label fw-semibold small">Category</label>
            <select name="category_id" class="form-select">
                <option value="">All Categories</option>
                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($category->id); ?>" <?php echo e(request('category_id') == $category->id ? 'selected' : ''); ?>>
                        <?php echo e($category->name); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="col-md-2">
            <label class="form-label fw-semibold small">File Type</label>
            <select name="file_type" class="form-select">
                <option value="">All Types</option>
                <option value="PDF"  <?php echo e(request('file_type') === 'PDF'  ? 'selected' : ''); ?>>PDF</option>
                <option value="ePub" <?php echo e(request('file_type') === 'ePub' ? 'selected' : ''); ?>>ePub</option>
                <option value="MP3"  <?php echo e(request('file_type') === 'MP3'  ? 'selected' : ''); ?>>MP3</option>
            </select>
        </div>
        <div class="col-md-3 d-flex gap-2">
            <button type="submit" class="btn btn-primary w-100">
                <i class="bi bi-search me-1"></i> Search
            </button>
            <a href="<?php echo e(route('search.index')); ?>" class="btn btn-outline-secondary">
                <i class="bi bi-x-lg"></i>
            </a>
        </div>
    </form>
</div>


<div class="d-flex justify-content-between align-items-center mb-3">
    <small class="text-muted"><?php echo e($eResources->total()); ?> resource(s) found</small>
</div>

<?php if($eResources->isEmpty()): ?>
    <div class="text-center py-5 text-muted">
        <i class="bi bi-inbox fs-1 d-block mb-2"></i>
        No resources found. Try a different search.
    </div>
<?php else: ?>
<div class="row g-3">
    <?php $__currentLoopData = $eResources; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $resource): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between mb-2">
                    <span class="badge bg-light text-dark border"><?php echo e($resource->category->name); ?></span>
                    <span class="badge bg-primary"><?php echo e($resource->file_type ?? 'N/A'); ?></span>
                </div>
                <h6 class="fw-bold mb-1"><?php echo e($resource->title); ?></h6>
                <p class="text-muted small mb-2">
                    <i class="bi bi-person me-1"></i><?php echo e($resource->author->full_name); ?>

                    &nbsp;·&nbsp;
                    <i class="bi bi-building me-1"></i><?php echo e($resource->publisher->name); ?>

                </p>
                <p class="text-muted small mb-3" style="font-size:0.8rem; line-height:1.4;">
                    <?php echo e(Str::limit($resource->description, 90)); ?>

                </p>
                <div class="d-flex gap-2">
                    <form method="POST" action="<?php echo e(route('search.access', $resource)); ?>" class="flex-grow-1">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="access_type" value="view">
                        <button type="submit" class="btn btn-sm btn-outline-primary w-100">
                            <i class="bi bi-eye me-1"></i>View
                        </button>
                    </form>
                    <form method="POST" action="<?php echo e(route('search.access', $resource)); ?>">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="access_type" value="download">
                        <button type="submit" class="btn btn-sm btn-outline-success">
                            <i class="bi bi-download"></i>
                        </button>
                    </form>
                </div>
            </div>
            <?php if($resource->publication_year): ?>
            <div class="card-footer bg-transparent text-muted small">
                <i class="bi bi-calendar3 me-1"></i>Published <?php echo e($resource->publication_year); ?>

            </div>
            <?php endif; ?>
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>

<div class="mt-4">
    <?php echo e($eResources->links()); ?>

</div>
<?php endif; ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Baby\Desktop\laravel\kandalayang-library\resources\views/search/index.blade.php ENDPATH**/ ?>