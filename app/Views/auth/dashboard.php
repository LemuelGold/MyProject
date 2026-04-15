<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f5f5f5; }
        .sidebar { background: white; border-right: 2px solid #ddd; min-height: 100vh; }
        .sidebar-menu a { display: block; padding: 12px 20px; color: #666; text-decoration: none; font-weight: 500; transition: all 0.2s; font-size: 0.95rem; }
        .sidebar-menu a:hover, .sidebar-menu a.active { background-color: #f0f0f0; color: #333; }
        .module-card { border: 2px solid #ddd !important; transition: all 0.3s; }
        .module-card:hover { border-color: #333 !important; transform: translateY(-2px); box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
    </style>
</head>
<body>
<?php
$role   = strtolower(session('user_role') ?? 'admin');
$prefix = $role === 'secretary' ? 'secretary' : 'admin';
$label  = $role === 'secretary' ? 'Secretary' : 'Admin';
if (!session('isLoggedIn')) { $role = 'admin'; $prefix = 'admin'; $label = 'Admin'; }
?>
<div class="container-fluid">
    <div class="row g-0">
        <div class="col-md-2 sidebar py-4">
            <div class="fw-bold px-3 mb-4" style="font-size:1.5rem;color:#333;"><?= $label ?></div>
            <ul class="list-unstyled sidebar-menu mb-0">
                <li><a href="<?= base_url($prefix) ?>" class="active">Dashboard</a></li>
                <li><a href="<?= base_url($prefix . '/conferences') ?>">Conferences</a></li>
                <li><a href="<?= base_url($prefix . '/conference-records') ?>">Conference Records</a></li>
                <li><a href="<?= base_url($prefix . '/student-violation') ?>">Student Violation</a></li>
                <li><a href="<?= base_url($prefix . '/violation-records') ?>">Violation Records</a></li>
                <?php if ($role === 'admin'): ?>
                <li><a href="<?= base_url('admin/user-management') ?>">User Management</a></li>
                <?php endif; ?>
                <li><a href="<?= base_url('auth/logout') ?>" class="text-secondary mt-3 d-block">Logout</a></li>
            </ul>
        </div>

        <div class="col-md-10 p-4">
            <?php if ($role === 'admin'): ?>
                <h1 class="fw-bold text-dark mb-4" style="font-size:1.8rem;">Admin Dashboard</h1>
                <div class="row g-3">
                    <?php
                    $cards = [
                        ['url' => 'admin/conferences',        'title' => 'Conferences',        'desc' => 'Schedule and manage student conferences'],
                        ['url' => 'admin/conference-records', 'title' => 'Conference Records', 'desc' => 'View all conference history and records'],
                        ['url' => 'admin/student-violation',  'title' => 'Student Violation',  'desc' => 'Record student violations and incidents'],
                        ['url' => 'admin/violation-records',  'title' => 'Violation Records',  'desc' => 'View all violation records and reports'],
                        ['url' => 'admin/user-management',    'title' => 'User Management',    'desc' => 'Manage admin and secretary accounts'],
                    ];
                    foreach ($cards as $card): ?>
                    <div class="col-md-6">
                        <a href="<?= base_url($card['url']) ?>" class="module-card card text-decoration-none text-dark p-4 d-block rounded-3">
                            <div class="fw-semibold mb-2" style="font-size:1.2rem;"><?= $card['title'] ?></div>
                            <div class="text-secondary" style="font-size:0.9rem;"><?= $card['desc'] ?></div>
                        </a>
                    </div>
                    <?php endforeach; ?>
                </div>

            <?php elseif ($role === 'secretary'): ?>
                <h1 class="fw-bold text-dark mb-4" style="font-size:1.8rem;">Secretary Dashboard</h1>
                <div class="row g-3">
                    <?php
                    $cards = [
                        ['url' => 'secretary/conferences',        'title' => 'Conferences',        'desc' => 'Schedule and manage student conferences'],
                        ['url' => 'secretary/conference-records', 'title' => 'Conference Records', 'desc' => 'View all conference history and records'],
                        ['url' => 'secretary/student-violation',  'title' => 'Student Violation',  'desc' => 'Record student violations and incidents'],
                        ['url' => 'secretary/violation-records',  'title' => 'Violation Records',  'desc' => 'View all violation records and reports'],
                    ];
                    foreach ($cards as $card): ?>
                    <div class="col-md-6">
                        <a href="<?= base_url($card['url']) ?>" class="module-card card text-decoration-none text-dark p-4 d-block rounded-3">
                            <div class="fw-semibold mb-2" style="font-size:1.2rem;"><?= $card['title'] ?></div>
                            <div class="text-secondary" style="font-size:0.9rem;"><?= $card['desc'] ?></div>
                        </a>
                    </div>
                    <?php endforeach; ?>
                </div>

            <?php else: ?>
                <h1 class="fw-bold text-dark mb-4">Dashboard</h1>
                <div class="alert alert-warning">Unknown role. Please contact the administrator.</div>
            <?php endif; ?>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

