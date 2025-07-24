<?= $this->extend('layouts/auth') ?>

<?= $this->section('title') ?>
<?= lang('Auth.registerTitle') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="card auth-card">
    <div class="card-header">
        <h4 class="m-0"><?= lang('Auth.registerTitle') ?></h4>
    </div>
    <div class="card-body">
        <?php if (isset($errors) && is_array($errors)): ?>
            <div class="alert alert-danger">
                <ul class="mb-0">
                    <?php foreach ($errors as $error): ?>
                        <li><?= esc($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        
        <?php if (isset($validation)): ?>
            <?php if ($validation->hasError('name')): ?>
                <div class="alert alert-danger">
                    <?= esc($validation->getError('name')) ?>
                </div>
            <?php endif; ?>
            
            <?php if ($validation->hasError('email')): ?>
                <div class="alert alert-danger">
                    <?= esc($validation->getError('email')) ?>
                </div>
            <?php endif; ?>
            
            <?php if ($validation->hasError('phone')): ?>
                <div class="alert alert-danger">
                    <?= esc($validation->getError('phone')) ?>
                </div>
            <?php endif; ?>
            
            <?php if ($validation->hasError('password')): ?>
                <div class="alert alert-danger">
                    <?= esc($validation->getError('password')) ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>

        <form action="<?= site_url('register') ?>" method="post" id="registerForm">
            <?= csrf_field() ?>

            <div class="mb-3">
                <label for="name" class="form-label"><?= lang('Auth.name') ?></label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                    <input type="text" class="form-control" id="name" name="name" value="<?= old('name') ?>" required>
                </div>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label"><?= lang('Auth.email') ?></label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                    <input type="email" class="form-control" id="email" name="email" value="<?= old('email') ?>" required>
                </div>
            </div>

            <div class="mb-3">
                <label for="phone" class="form-label"><?= lang('Auth.phone') ?></label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-phone"></i></span>
                    <input type="text" class="form-control" id="phone" name="phone" value="<?= old('phone') ?>" required>
                </div>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label"><?= lang('Auth.password') ?></label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="form-text"><?= lang('Auth.passwordHint') ?? 'Password must be at least 6 characters long.' ?></div>
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-success btn-lg">
                    <i class="fas fa-user-plus me-2"></i> <?= lang('Auth.registerButton') ?>
                </button>
            </div>
        </form>

        <div class="text-center mt-4">
            <p><?= lang('Auth.alreadyHaveAccount') ?? 'Already have an account?' ?> 
                <a href="<?= site_url('login') ?>"><?= lang('Auth.loginLink') ?></a>
            </p>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    $(document).ready(function() {
        // Focus on name field when page loads
        $('#name').focus();
        
        // Phone number formatting (optional)
        $('#phone').on('input', function() {
            // Format phone number if needed
            // This is just a placeholder for potential phone formatting
        });
    });
</script>
<?= $this->endSection() ?>
