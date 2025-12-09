<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container mt-4">
    <h3>Edit User</h3>
    <hr>

    <form action="<?= site_url('users/update/'.$user['id']) ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>

        <div class="mb-3">
            <label class="form-label">Fullname</label>
            <input type="text" name="fullname" class="form-control" 
                   value="<?= old('fullname', $user['fullname']) ?>">
            <small class="text-danger"><?= $validation->getError('fullname') ?></small>
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" 
                   value="<?= old('email', $user['email']) ?>">
            <small class="text-danger"><?= $validation->getError('email') ?></small>
        </div>

        <div class="mb-3">
            <label class="form-label">Mobile</label>
            <input type="text" name="mobile" class="form-control" 
                   value="<?= old('mobile', $user['mobile']) ?>">
            <small class="text-danger"><?= $validation->getError('mobile') ?></small>
        </div>

        <div class="mb-3">
            <label class="form-label">New Password (optional)</label>
            <input type="password" name="password" class="form-control">
            <small class="text-danger"><?= $validation->getError('password') ?></small>
        </div>

        <div class="mb-3">
            <label class="form-label">Current File</label><br>

            <?php if ($user['profile_file']): ?>
                <?php
                    $fileExt = pathinfo($user['profile_file'], PATHINFO_EXTENSION);
                    $isImage = in_array(strtolower($fileExt), ['jpg','jpeg','png','gif','webp']);
                ?>

                <?php if ($isImage): ?>
                    <img src="<?= base_url($user['profile_file']) ?>" 
                         width="70" height="70" style="object-fit:cover;">
                <?php else: ?>
                    <a href="<?= base_url($user['profile_file']) ?>" target="_blank">View File</a>
                <?php endif; ?>

            <?php else: ?>
                -
            <?php endif; ?>
        </div>

        <div class="mb-3">
            <label class="form-label">Upload New File</label>
            <input type="file" name="profile_file" class="form-control">
            <small class="text-danger"><?= $validation->getError('profile_file') ?></small>
        </div>

        <button class="btn btn-primary">Update</button>
        <a href="<?= site_url('users') ?>" class="btn btn-secondary">Back</a>
    </form>
</div>
<?= $this->endSection() ?>
