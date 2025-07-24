<?= $this->extend('layouts/auth') ?>

<?= $this->section('title') ?>
<?= lang('Auth.loginTitle') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="card auth-card">
    <div class="card-header">
        <h4 class="m-0"><?= lang('Auth.loginTitle') ?></h4>
    </div>
    <div class="card-body">
        <?php if (isset($validation) && $validation->hasError('email')): ?>
            <div class="alert alert-danger">
                <?= esc($validation->getError('email')) ?>
            </div>
        <?php endif; ?>
        
        <?php if (isset($validation) && $validation->hasError('password')): ?>
            <div class="alert alert-danger">
                <?= esc($validation->getError('password')) ?>
            </div>
        <?php endif; ?>

        <form action="<?= site_url('login') ?>" method="post">
            <?= csrf_field() ?>

            <div class="mb-3">
                <label for="email" class="form-label"><?= lang('Auth.email') ?></label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                    <input type="email" class="form-control" id="email" name="email" value="<?= old('email') ?>" required>
                </div>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label"><?= lang('Auth.password') ?></label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="fas fa-sign-in-alt me-2"></i> <?= lang('Auth.loginButton') ?>
                </button>
            </div>
        </form>

        <div class="text-center mt-4">
            <p><?= lang('Auth.noAccount') ?? "Don't have an account?" ?> 
                <a href="<?= site_url('register') ?>"><?= lang('Auth.registerLink') ?></a>
            </p>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    $(document).ready(function() {
        // Focus on email field when page loads
        $('#email').focus();
    });
</script>
<?= $this->endSection() ?>
