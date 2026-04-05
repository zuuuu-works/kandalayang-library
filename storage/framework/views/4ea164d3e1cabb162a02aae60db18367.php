
<?php $__env->startSection('title', isset($eResource) ? 'Edit E-Resource' : 'Add E-Resource'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <h4>
        <i class="bi bi-<?php echo e(isset($eResource) ? 'pencil' : 'plus-circle'); ?> me-2"></i>
        <?php echo e(isset($eResource) ? 'Edit E-Resource' : 'Add New E-Resource'); ?>

    </h4>
</div>

<div class="card p-4" style="max-width: 760px;">
    <form method="POST"
          action="<?php echo e(isset($eResource) ? route('e-resources.update', $eResource) : route('e-resources.store')); ?>"
          enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <?php if(isset($eResource)): ?> <?php echo method_field('PUT'); ?> <?php endif; ?>

        <?php if($errors->any()): ?>
            <div class="alert alert-danger">
                <ul class="mb-0 ps-3">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>

        
        <div class="mb-3">
            <label class="form-label fw-semibold">Title <span class="text-danger">*</span></label>
            <input type="text" name="title" class="form-control <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                   value="<?php echo e(old('title', $eResource->title ?? '')); ?>" required>
        </div>

        
        <div class="mb-3">
            <label class="form-label fw-semibold">Description</label>
            <textarea name="description" rows="3"
                      class="form-control <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"><?php echo e(old('description', $eResource->description ?? '')); ?></textarea>
        </div>

        <div class="row g-3 mb-3">
            <div class="col-md-4">
                <label class="form-label fw-semibold">Category <span class="text-danger">*</span></label>
                <select name="category_id" class="form-select <?php $__errorArgs = ['category_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                    <option value="">-- Select --</option>
                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($cat->id); ?>"
                            <?php echo e(old('category_id', $eResource->category_id ?? '') == $cat->id ? 'selected' : ''); ?>>
                            <?php echo e($cat->name); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Author <span class="text-danger">*</span></label>
                <select name="author_id" class="form-select <?php $__errorArgs = ['author_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                    <option value="">-- Select --</option>
                    <?php $__currentLoopData = $authors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $author): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($author->id); ?>"
                            <?php echo e(old('author_id', $eResource->author_id ?? '') == $author->id ? 'selected' : ''); ?>>
                            <?php echo e($author->full_name); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Publisher <span class="text-danger">*</span></label>
                <select name="publisher_id" class="form-select <?php $__errorArgs = ['publisher_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                    <option value="">-- Select --</option>
                    <?php $__currentLoopData = $publishers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pub): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($pub->id); ?>"
                            <?php echo e(old('publisher_id', $eResource->publisher_id ?? '') == $pub->id ? 'selected' : ''); ?>>
                            <?php echo e($pub->name); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
        </div>

        <div class="row g-3 mb-3">
            <div class="col-md-4">
                <label class="form-label fw-semibold">ISBN</label>
                <input type="text" name="isbn" class="form-control"
                       value="<?php echo e(old('isbn', $eResource->isbn ?? '')); ?>">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Publication Year</label>
                <input type="number" name="publication_year" class="form-control"
                       value="<?php echo e(old('publication_year', $eResource->publication_year ?? '')); ?>"
                       min="1900" max="<?php echo e(date('Y')); ?>">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">File Type</label>
                <select name="file_type" class="form-select">
                    <option value="">-- Select --</option>
                    <?php $__currentLoopData = ['PDF','ePub','MP3','MP4','DOCX']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($type); ?>"
                            <?php echo e(old('file_type', $eResource->file_type ?? '') === $type ? 'selected' : ''); ?>>
                            <?php echo e($type); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
        </div>

        
        <div class="mb-3">
            <label class="form-label fw-semibold">Upload File <span class="text-muted small">(PDF, ePub, MP3, MP4, DOCX — max 50MB)</span></label>

            <?php if(isset($eResource) && $eResource->file_path): ?>
                
                <div class="alert alert-info py-2 mb-2 d-flex align-items-center justify-content-between">
                    <span><i class="bi bi-file-earmark-check me-2"></i>Current file: <strong><?php echo e(basename($eResource->file_path)); ?></strong></span>
                    <a href="<?php echo e(route('file.access', ['eResource' => $eResource, 'type' => 'view'])); ?>"
                       target="_blank" class="btn btn-sm btn-outline-primary">
                        <i class="bi bi-eye me-1"></i>Preview
                    </a>
                </div>
            <?php endif; ?>

            <input type="file" name="file_upload"
                   class="form-control <?php $__errorArgs = ['file_upload'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                   accept=".pdf,.epub,.mp3,.mp4,.docx">
            <div class="form-text">Upload a new file to replace the existing one.</div>
        </div>

        
        <div class="mb-4">
            <label class="form-label fw-semibold">OR External URL <span class="text-muted small">(Google Drive, website link, etc.)</span></label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-link-45deg"></i></span>
                <input type="url" name="file_url" class="form-control <?php $__errorArgs = ['file_url'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                       value="<?php echo e(old('file_url', $eResource->file_url ?? '')); ?>"
                       placeholder="https://drive.google.com/...">
            </div>
            <div class="form-text">Use this if the file is hosted externally. Leave blank if you uploaded a file above.</div>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary px-4">
                <i class="bi bi-check-circle me-1"></i>
                <?php echo e(isset($eResource) ? 'Update Resource' : 'Save Resource'); ?>

            </button>
            <a href="<?php echo e(route('e-resources.index')); ?>" class="btn btn-outline-secondary">Cancel</a>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Baby\Desktop\laravel\kandalayang-library\resources\views/e-resources/form.blade.php ENDPATH**/ ?>