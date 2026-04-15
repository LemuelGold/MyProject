<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f5f5f5; }
        .sidebar { background: white; border-right: 2px solid #ddd; min-height: 100vh; }
        .sidebar-menu a { display: block; padding: 12px 20px; color: #666; text-decoration: none; font-weight: 500; transition: all 0.2s; font-size: 0.95rem; }
        .sidebar-menu a:hover, .sidebar-menu a.active { background-color: #f0f0f0; color: #333; }
        .page-title { background-color: #ddd; border-radius: 8px; }
        .table th { background-color: #333; color: white; font-size: 0.85rem; }
        .table td { font-size: 0.85rem; vertical-align: middle; }
        .form-control, .form-select { border: 2px solid #ddd; background-color: #f0f0f0; font-size: 0.9rem; }
        .form-control:focus, .form-select:focus { border-color: #666; box-shadow: none; background-color: white; }
        .modal-label { font-weight: 600; color: #555; font-size: 0.85rem; }
        .badge-role { display: inline-block; padding: 3px 10px; border-radius: 20px; font-size: 0.78rem; font-weight: 700; color: #fff; }
        .badge-admin { background-color: #333; }
        .badge-secretary { background-color: #2563a8; }
        .badge-other { background-color: #6c757d; }
        .badge-status { display: inline-block; padding: 3px 10px; border-radius: 20px; font-size: 0.78rem; font-weight: 700; color: #fff; }
        .badge-active { background-color: #198754; }
        .badge-inactive { background-color: #aaa; }
    </style>
</head>
<body>
<?php $active = 'user-management'; ?>
<div class="container-fluid">
    <div class="row g-0">
        <?= view('partials/sidebar') ?>

        <div class="col-md-10 p-4">
            <h1 class="page-title text-center fw-bold text-dark py-3 px-4 mb-4" style="font-size:1.5rem;">User Management</h1>

            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
            <?php endif; ?>

            <div class="mb-3 text-end">
                <button class="btn fw-semibold text-white px-3 py-2" style="background-color:#333;" data-bs-toggle="modal" data-bs-target="#addUserModal">+ Add User</button>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>#</th><th>Username</th><th>First Name</th><th>Last Name</th>
                            <th>Email</th><th>Role</th><th>Status</th><th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $i => $user): ?>
                        <tr>
                            <td><?= $i + 1 ?></td>
                            <td><?= esc($user['username']) ?></td>
                            <td><?= esc($user['first_name']) ?></td>
                            <td><?= esc($user['last_name']) ?></td>
                            <td><?= esc($user['email']) ?></td>
                            <td><?php
                                $rk = strtolower(esc($user['role']));
                                $rc = in_array($rk, ['admin','secretary']) ? $rk : 'other';
                                echo '<span class="badge-role badge-'.$rc.'">'.esc(ucfirst($user['role'])).'</span>';
                            ?></td>
                            <td><span class="badge-status badge-<?= esc($user['status']) ?>"><?= esc(ucfirst($user['status'])) ?></span></td>
                            <td style="white-space:nowrap;">
                                <button class="btn btn-sm fw-semibold text-white me-1" style="background-color:#2563a8;"
                                    onclick="editUser(<?= htmlspecialchars(json_encode([
                                        'id'         => $user['id'],
                                        'username'   => $user['username'],
                                        'first_name' => $user['first_name'],
                                        'last_name'  => $user['last_name'],
                                        'email'      => $user['email'],
                                        'role'       => $user['role'],
                                        'status'     => $user['status'],
                                    ]), ENT_QUOTES) ?>)">Edit</button>
                                <form method="post" action="<?= base_url('admin/user-management/delete') ?>" style="display:inline;" onsubmit="return confirm('Delete this user?')">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="id" value="<?= $user['id'] ?>">
                                    <button type="submit" class="btn btn-sm btn-danger fw-semibold">Delete</button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Add User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#333;color:white;">
                <h5 class="modal-title">Add User</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= base_url('admin/user-management/save') ?>" method="post">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6"><label class="modal-label mb-1">First Name</label><input type="text" class="form-control" name="first_name" required></div>
                        <div class="col-md-6"><label class="modal-label mb-1">Last Name</label><input type="text" class="form-control" name="last_name" required></div>
                        <div class="col-md-6"><label class="modal-label mb-1">Username</label><input type="text" class="form-control" name="username" required></div>
                        <div class="col-md-6"><label class="modal-label mb-1">Email</label><input type="email" class="form-control" name="email" required></div>
                        <div class="col-md-6">
                            <label class="modal-label mb-1">Role</label>
                            <select class="form-select" name="role" required>
                                <option value="admin">Admin</option>
                                <option value="secretary">Secretary</option>
                            </select>
                        </div>
                        <div class="col-md-6"><label class="modal-label mb-1">Password</label><input type="password" class="form-control" name="password" required></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn fw-semibold text-white" style="background-color:#333;">Save User</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit User Modal -->
<div class="modal fade" id="editUserModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#2563a8;color:white;">
                <h5 class="modal-title">Edit User</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= base_url('admin/user-management/update') ?>" method="post">
                <?= csrf_field() ?>
                <input type="hidden" name="id" id="eu-id">
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6"><label class="modal-label mb-1">First Name</label><input type="text" class="form-control" name="first_name" id="eu-firstname" required></div>
                        <div class="col-md-6"><label class="modal-label mb-1">Last Name</label><input type="text" class="form-control" name="last_name" id="eu-lastname" required></div>
                        <div class="col-md-6"><label class="modal-label mb-1">Username</label><input type="text" class="form-control" name="username" id="eu-username" required></div>
                        <div class="col-md-6"><label class="modal-label mb-1">Email</label><input type="email" class="form-control" name="email" id="eu-email" required></div>
                        <div class="col-md-6">
                            <label class="modal-label mb-1">Role</label>
                            <select class="form-select" name="role" id="eu-role">
                                <option value="admin">Admin</option>
                                <option value="secretary">Secretary</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="modal-label mb-1">Status</label>
                            <select class="form-select" name="status" id="eu-status">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label class="modal-label mb-1">New Password <span class="fw-normal text-secondary">(leave blank to keep current)</span></label>
                            <input type="password" class="form-control" name="password">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn fw-semibold text-white" style="background-color:#2563a8;">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function editUser(data) {
        document.getElementById('eu-id').value        = data.id;
        document.getElementById('eu-firstname').value = data.first_name;
        document.getElementById('eu-lastname').value  = data.last_name;
        document.getElementById('eu-username').value  = data.username;
        document.getElementById('eu-email').value     = data.email;
        document.getElementById('eu-role').value      = data.role;
        document.getElementById('eu-status').value    = data.status;
        new bootstrap.Modal(document.getElementById('editUserModal')).show();
    }
</script>
</body>
</html>
