<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container mt-4">
    <div class="d-flex justify-content-between mb-3">
        <h3>Users List</h3>
        <a href="<?= site_url('users/create') ?>" class="btn btn-primary">Add New</a>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Fullname</th>
                <th>Email</th>
                <th>Mobile</th>
                <th>Profile File</th>
                <th width="180">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($users): ?>
                <?php foreach ($users as $u): ?>
                <tr>
                    <td><?= $u['id'] ?></td>
                    <td><?= esc($u['fullname']) ?></td>
                    <td><?= esc($u['email']) ?></td>
                    <td><?= esc($u['mobile']) ?></td>

                    <td>
                        <?php if ($u['profile_file']): ?>
                            <?php
                                $fileExt = pathinfo($u['profile_file'], PATHINFO_EXTENSION);
                                $isImage = in_array(strtolower($fileExt), ['jpg','jpeg','png','gif','webp']);
                            ?>

                            <?php if ($isImage): ?>
                                <img src="<?= base_url($u['profile_file']) ?>" 
                                     alt="Profile" width="60" height="60" style="object-fit:cover;">
                            <?php else: ?>
                                <a href="<?= base_url($u['profile_file']) ?>" target="_blank">
                                    View File
                                </a>
                            <?php endif; ?>
                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </td>

                    <td>
                        <a href="<?= site_url('users/edit/'.$u['id']) ?>" class="btn btn-sm btn-warning">Edit</a>

                        <form action="<?= site_url('users/delete/'.$u['id']) ?>" method="post" class="d-inline">
                            <?= csrf_field() ?>
                            <button onclick="return confirm('Delete this user?')" 
                                    class="btn btn-sm btn-danger">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="6" class="text-center">No users found</td></tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div>
        <?= $pager->links() ?>
    </div>
</div>
<?= $this->endSection() ?>
