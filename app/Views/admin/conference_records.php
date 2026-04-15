<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conference Records</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f5f5f5; }
        .sidebar { background: white; border-right: 2px solid #ddd; min-height: 100vh; }
        .sidebar-menu a { display: block; padding: 12px 20px; color: #666; text-decoration: none; font-weight: 500; transition: all 0.2s; font-size: 0.95rem; }
        .sidebar-menu a:hover, .sidebar-menu a.active { background-color: #f0f0f0; color: #333; }
        .page-title { background-color: #ddd; border-radius: 8px; }
    </style>
</head>
<body>
<?php $active = 'conference-records'; ?>
<div class="container-fluid">
    <div class="row g-0">
        <?= view('partials/sidebar') ?>
        <div class="col-md-10 p-4">
            <h1 class="page-title text-center fw-bold text-dark py-3 px-4 mb-4" style="font-size:1.5rem;">Conference Records</h1>
            <div class="alert alert-info">Conference records will be displayed here.</div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
