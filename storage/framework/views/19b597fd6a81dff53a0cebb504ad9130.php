
<?php $__env->startSection('title', isset($author) ? 'Edit Author' : 'Add Author'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <h4>
        <i class="bi bi-<?php echo e(isset($author) ? 'pencil' : 'person-plus'); ?> me-2"></i>
        <?php echo e(isset($author) ? 'Edit Author' : 'Add New Author'); ?>

    </h4>
</div>

<div class="card p-4" style="max-width: 560px;">
    <form method="POST"
          action="<?php echo e(isset($author) ? route('authors.update', $author) : route('authors.store')); ?>">
        <?php echo csrf_field(); ?>
        <?php if(isset($author)): ?> <?php echo method_field('PUT'); ?> <?php endif; ?>

        <?php if($errors->any()): ?>
            <div class="alert alert-danger">
                <ul class="mb-0 ps-3">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>

        <div class="row g-3 mb-3">
            <div class="col">
                <label class="form-label fw-semibold">First Name <span class="text-danger">*</span></label>
                <input type="text" name="first_name" class="form-control <?php $__errorArgs = ['first_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                       value="<?php echo e(old('first_name', $author->first_name ?? '')); ?>"
                       placeholder="Juan" required>
            </div>
            <div class="col">
                <label class="form-label fw-semibold">Last Name <span class="text-danger">*</span></label>
                <input type="text" name="last_name" class="form-control <?php $__errorArgs = ['last_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                       value="<?php echo e(old('last_name', $author->last_name ?? '')); ?>"
                       placeholder="Dela Cruz" required>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Email</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                <input type="email" name="email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                       value="<?php echo e(old('email', $author->email ?? '')); ?>"
                       placeholder="author@example.com">
            </div>
        </div>

        <div class="mb-4">
            <label class="form-label fw-semibold">Bio</label>
            <textarea name="bio" rows="3" class="form-control <?php $__errorArgs = ['bio'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                      placeholder="Short biography of the author..."><?php echo e(old('bio', $author->bio ?? '')); ?></textarea>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary px-4">
                <i class="bi bi-check-circle me-1"></i>
                <?php echo e(isset($author) ? 'Update Author' : 'Save Author'); ?>

            </button>
            <a href="<?php echo e(route('authors.index')); ?>" class="btn btn-outline-secondary">Cancel</a>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Baby\Desktop\laravel\kandalayang-library\resources\views/authors/form.blade.php ENDPATH**/ ?>