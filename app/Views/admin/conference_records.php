<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conference Records</title>
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
            font-size: 1.5rem;
            font-weight: 700;
            color: #333;
            text-align: center;
            background-color: #ddd;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 30px;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2 sidebar">
                <div class="sidebar-title">Admin</div>
                <ul class="sidebar-menu">
                    <li><a href="<?= base_url('admin') ?>">Dashboard</a></li>
                    <li><a href="<?= base_url('admin/conferences') ?>">Conferences</a></li>
                    <li><a href="<?= base_url('admin/conference-records') ?>" class="active">Conference Records</a></li>
                    <li><a href="<?= base_url('admin/student-violation') ?>">Student Violation</a></li>
                    <li><a href="<?= base_url('admin/violation-records') ?>">Violation Records</a></li>
                    <li><a href="<?= base_url('auth/login') ?>" style="color: #999; margin-top: 20px;">Logout</a></li>
                </ul>
            </div>
            
            <div class="col-md-10 main-content">
                <h1 class="page-title">Conference Records</h1>
                <div class="alert alert-info">Conference records will be displayed here.</div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
