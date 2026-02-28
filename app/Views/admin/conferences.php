<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conferences</title>
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
        .form-container {
            background: white;
            border: 2px solid #ddd;
            border-radius: 10px;
            padding: 30px;
            max-width: 900px;
            margin: 0 auto;
        }
        .form-label {
            font-weight: 600;
            color: #333;
            font-size: 0.9rem;
            margin-bottom: 8px;
        }
        .form-control, .form-select {
            border: 2px solid #ddd;
            border-radius: 5px;
            padding: 8px 12px;
            font-size: 0.9rem;
            background-color: #f0f0f0;
        }
        .form-control:focus, .form-select:focus {
            border-color: #666;
            box-shadow: none;
            background-color: white;
        }
        .btn-submit {
            background-color: #333;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px 30px;
            font-size: 0.95rem;
            font-weight: 600;
            margin-top: 20px;
        }
        .btn-submit:hover {
            background-color: #555;
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
                    <li><a href="<?= base_url('admin/conferences') ?>" class="active">Conferences</a></li>
                    <li><a href="<?= base_url('admin/conference-records') ?>">Conference Records</a></li>
                    <li><a href="<?= base_url('admin/student-violation') ?>">Student Violation</a></li>
                    <li><a href="<?= base_url('admin/violation-records') ?>">Violation Records</a></li>
                    <li><a href="<?= base_url('auth/login') ?>" style="color: #999; margin-top: 20px;">Logout</a></li>
                </ul>
            </div>
            
            <div class="col-md-10 main-content">
                <h1 class="page-title">Conferences</h1>
                
                <div class="form-container">
                    <form action="<?= base_url('admin/conferences/save') ?>" method="post">
                        <?= csrf_field() ?>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Name" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="student_id" class="form-label">Student ID Number</label>
                                <input type="text" class="form-control" id="student_id" name="student_id" placeholder="Student ID Number" required>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="course_year" class="form-label">Course And Year</label>
                                <select class="form-select" id="course_year" name="course_year" required>
                                    <option value="" selected>Select</option>
                                    <option value="BSIT 1">BSIT 1</option>
                                    <option value="BSIT 2">BSIT 2</option>
                                    <option value="BSIT 3">BSIT 3</option>
                                    <option value="BSIT 4">BSIT 4</option>
                                    <option value="BSCS 1">BSCS 1</option>
                                    <option value="BSCS 2">BSCS 2</option>
                                    <option value="BSCS 3">BSCS 3</option>
                                    <option value="BSCS 4">BSCS 4</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="date_time" class="form-label">Date And Time</label>
                                <input type="datetime-local" class="form-control" id="date_time" name="date_time" required>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="semester" class="form-label">Semester</label>
                                <select class="form-select" id="semester" name="semester" required>
                                    <option value="" selected>Select</option>
                                    <option value="1st Semester">1st Semester</option>
                                    <option value="2nd Semester">2nd Semester</option>
                                    <option value="Summer">Summer</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="violation_id" class="form-label">Violation</label>
                                <select class="form-select" id="violation_id" name="violation_id" required>
                                    <option value="" selected>Select</option>
                                    <?php
                                    $db = \Config\Database::connect();
                                    $violations = $db->table('violations')->get()->getResultArray();
                                    foreach ($violations as $violation): ?>
                                        <option value="<?= $violation['id'] ?>"><?= $violation['violation_name'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="phase" class="form-label">Phases</label>
                                <select class="form-select" id="phase" name="phase" required>
                                    <option value="" selected>Select</option>
                                    <option value="Phase 1">Phase 1</option>
                                    <option value="Phase 2">Phase 2</option>
                                    <option value="Phase 3">Phase 3</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="description" class="form-label">Description/ Optional</label>
                                <input type="text" class="form-control" id="description" name="description" placeholder="Description">
                            </div>
                        </div>
                        
                        <div class="text-center">
                            <button type="submit" class="btn btn-submit">Submit Conference</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
