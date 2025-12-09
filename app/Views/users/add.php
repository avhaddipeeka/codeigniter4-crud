<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container mt-4">
    <h3>Add User</h3>
    <hr>

    <form action="<?= site_url('users/store') ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>

        <div class="mb-3">
            <label class="form-label">Fullname</label>
            <input type="text" name="fullname" class="form-control" 
                   value="<?= old('fullname') ?>">
            <small class="text-danger"><?= $validation->getError('fullname') ?></small>
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" 
                   value="<?= old('email') ?>">
            <small class="text-danger"><?= $validation->getError('email') ?></small>
        </div>

        <div class="mb-3">
            <label class="form-label">Mobile</label>
            <input type="text" name="mobile" class="form-control" 
                   value="<?= old('mobile') ?>">
            <small class="text-danger"><?= $validation->getError('mobile') ?></small>
        </div>

        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control">
            <small class="text-danger"><?= $validation->getError('password') ?></small>
        </div>

        <div class="mb-3">
            <label class="form-label">Profile File (Image / PDF)</label>
            <input type="file" name="profile_file" class="form-control">
            <small class="text-danger"><?= $validation->getError('profile_file') ?></small>
        </div>

        <button class="btn btn-success">Save</button>
        <a href="<?= site_url('users') ?>" class="btn btn-secondary">Back</a>
    </form>
</div>
<?= $this->endSection() ?>
