<?php
$role   = strtolower(session('role') ?? 'admin');
$prefix = $role === 'secretary' ? 'secretary' : 'admin';
$label  = $role === 'secretary' ? 'Secretary' : 'Admin';
$active = $active ?? '';
?>
<div class="col-md-2 sidebar py-4">
    <div class="fw-bold px-3 mb-4" style="font-size:1.5rem;color:#333;"><?= $label ?></div>
    <ul class="list-unstyled sidebar-menu mb-0">
        <li><a href="<?= base_url($prefix) ?>" class="<?= $active==='dashboard'?'active':'' ?>">Dashboard</a></li>
        <li><a href="<?= base_url($prefix.'/conferences') ?>" class="<?= $active==='conferences'?'active':'' ?>">Conferences</a></li>
        <li><a href="<?= base_url($prefix.'/conference-records') ?>" class="<?= $active==='conference-records'?'active':'' ?>">Conference Records</a></li>
        <li><a href="<?= base_url($prefix.'/student-violation') ?>" class="<?= $active==='student-violation'?'active':'' ?>">Student Violation</a></li>
        <li><a href="<?= base_url($prefix.'/violation-records') ?>" class="<?= $active==='violation-records'?'active':'' ?>">Violation Records</a></li>
        <?php if ($role === 'admin'): ?>
        <li><a href="<?= base_url('admin/user-management') ?>" class="<?= $active==='user-management'?'active':'' ?>">User Management</a></li>
        <?php endif; ?>
        <li><a href="<?= base_url('auth/logout') ?>" class="text-secondary mt-3 d-block">Logout</a></li>
    </ul>
</div>
