<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f5f5f5;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        }
        .sidebar {
            background: white;
            border-right: 2px solid #ddd;
            min-height: 100vh;
            padding: 20px 0;
        }
        .sidebar-title {
            font-size: 1.5rem;
            font-weight: 700;
            padding: 0 20px;
            margin-bottom: 30px;
            color: #333;
        }
        .sidebar-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .sidebar-menu li {
            margin-bottom: 5px;
        }
        .sidebar-menu a {
            display: block;
            padding: 12px 20px;
            color: #666;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.2s;
        }
        .sidebar-menu a:hover,
        .sidebar-menu a.active {
            background-color: #f0f0f0;
            color: #333;
        }
        .main-content {
            padding: 30px;
        }
        .page-title {
            font-size: 1.8rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 30px;
        }
        .module-card {
            background: white;
            border: 2px solid #ddd;
            border-radius: 10px;
            padding: 30px;
            margin-bottom: 20px;
            transition: all 0.3s;
            cursor: pointer;
            text-decoration: none;
            display: block;
            color: inherit;
        }
        .module-card:hover {
            border-color: #333;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .module-title {
            font-size: 1.3rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 10px;
        }
        .module-desc {
            color: #666;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2 sidebar">
                <div class="sidebar-title">Admin</div>
                <ul class="sidebar-menu">
                    <li><a href="<?= base_url('admin') ?>" class="active">Dashboard</a></li>
                    <li><a href="<?= base_url('admin/conferences') ?>">Conferences</a></li>
                    <li><a href="<?= base_url('admin/conference-records') ?>">Conference Records</a></li>
                    <li><a href="<?= base_url('admin/student-violation') ?>">Student Violation</a></li>
                    <li><a href="<?= base_url('admin/violation-records') ?>">Violation Records</a></li>
                    <li><a href="<?= base_url('auth/login') ?>" style="color: #999; margin-top: 20px;">Logout</a></li>
                </ul>
            </div>
            
            <div class="col-md-10 main-content">
                <h1 class="page-title">Admin Dashboard</h1>
                
                <div class="row">
                    <div class="col-md-6">
                        <a href="<?= base_url('admin/conferences') ?>" class="module-card">
                            <div class="module-title">Conferences</div>
                            <div class="module-desc">Schedule and manage student conferences</div>
                        </a>
                    </div>
                    <div class="col-md-6">
                        <a href="<?= base_url('admin/conference-records') ?>" class="module-card">
                            <div class="module-title">Conference Records</div>
                            <div class="module-desc">View all conference history and records</div>
                        </a>
                    </div>
                    <div class="col-md-6">
                        <a href="<?= base_url('admin/student-violation') ?>" class="module-card">
                            <div class="module-title">Student Violation</div>
                            <div class="module-desc">Record student violations and incidents</div>
                        </a>
                    </div>
                    <div class="col-md-6">
                        <a href="<?= base_url('admin/violation-records') ?>" class="module-card">
                            <div class="module-title">Violation Records</div>
                            <div class="module-desc">View all violation records and reports</div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
