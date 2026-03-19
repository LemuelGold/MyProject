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
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Students and Faculty</label>
                                <select class="form-select" id="user_type" name="user_type" required onchange="toggleStudentIdFields()">
                                    <option value="" selected>Select</option>
                                    <option value="Students">Students</option>
                                    <option value="Faculty">Faculty</option>
                                    <option value="Personnel">Personnel</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form-label">Name <span id="student-id-label" style="display: none;">/ Student ID / Course / Year</span></label>
                                <div id="name-fields">
                                    <div class="row mb-2 name-row align-items-center">
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" name="names[]" placeholder="Name" required>
                                        </div>
                                        <div class="col-md-3 student-id-col" style="display: none;">
                                            <input type="text" class="form-control" name="student_ids[]" placeholder="Student ID Number">
                                        </div>
                                        <div class="col-md-2 student-id-col" style="display: none;">
                                            <select class="form-select" name="courses[]">
                                                <option value="">Course</option>
                                                <option value="BSIT">BSIT</option>
                                                <option value="BSCS">BSCS</option>
                                                <option value="BSED">BSED</option>
                                                <option value="BEED">BEED</option>
                                                <option value="BSA">BSA</option>
                                                <option value="BSHM">BSHM</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2 student-id-col" style="display: none;">
                                            <select class="form-select" name="year_levels[]">
                                                <option value="">Year</option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <button type="button" class="btn btn-outline-secondary w-100" onclick="addNameField()">+</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
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
                                <label for="school_year" class="form-label">School Year</label>
                                <select class="form-select" id="school_year" name="school_year" required>
                                    <option value="" selected>Select</option>
                                    <option value="2023-2024">2023-2024</option>
                                    <option value="2024-2025">2024-2025</option>
                                    <option value="2025-2026">2025-2026</option>
                                    <option value="2026-2027">2026-2027</option>
                                    <option value="2027-2028">2027-2028</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="row">
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
                            <div class="col-md-6 mb-3">
                                <label for="phase" class="form-label">Phases</label>
                                <select class="form-select" id="phase" name="phase" required>
                                    <option value="" selected>Select</option>
                                    <option value="Phase 1">Phase 1</option>
                                    <option value="Phase 2">Phase 2</option>
                                    <option value="Phase 3">Phase 3</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="description" class="form-label">Description/ Optional</label>
                                <textarea class="form-control" id="description" name="description" placeholder="Description" rows="4"></textarea>
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
    <script>
        function toggleStudentIdFields() {
            var userType = document.getElementById('user_type').value;
            var studentIdCols = document.querySelectorAll('.student-id-col');
            var studentIdLabel = document.getElementById('student-id-label');
            
            if (userType === 'Students') {
                studentIdLabel.style.display = 'inline';
                studentIdCols.forEach(col => col.style.display = 'block');
            } else {
                studentIdLabel.style.display = 'none';
                studentIdCols.forEach(col => {
                    col.style.display = 'none';
                    var inputs = col.querySelectorAll('input, select');
                    inputs.forEach(input => { input.value = ''; input.required = false; });
                });
            }
        }
        
        function addNameField() {
            var nameFields = document.getElementById('name-fields');
            var userType = document.getElementById('user_type').value;
            var isStudent = userType === 'Students';
            var show = isStudent ? 'block' : 'none';

            var newField = document.createElement('div');
            newField.className = 'row mb-2 name-row align-items-center';
            newField.innerHTML = `
                <div class="col-md-3">
                    <input type="text" class="form-control" name="names[]" placeholder="Name" required>
                </div>
                <div class="col-md-3 student-id-col" style="display: ${show};">
                    <input type="text" class="form-control" name="student_ids[]" placeholder="Student ID Number" ${isStudent ? 'required' : ''}>
                </div>
                <div class="col-md-2 student-id-col" style="display: ${show};">
                    <select class="form-select" name="courses[]" ${isStudent ? 'required' : ''}>
                        <option value="">Course</option>
                        <option value="BSIT">BSIT</option>
                        <option value="BSCS">BSCS</option>
                        <option value="BSED">BSED</option>
                        <option value="BEED">BEED</option>
                        <option value="BSA">BSA</option>
                        <option value="BSHM">BSHM</option>
                    </select>
                </div>
                <div class="col-md-2 student-id-col" style="display: ${show};">
                    <select class="form-select" name="year_levels[]" ${isStudent ? 'required' : ''}>
                        <option value="">Year</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-outline-danger w-100" onclick="removeNameField(this)">-</button>
                </div>
            `;
            nameFields.appendChild(newField);
        }
        
        function removeNameField(button) {
            var nameFields = document.getElementById('name-fields');
            if (nameFields.children.length > 1) {
                button.closest('.name-row').remove();
            }
        }
    </script>
</body>
</html>
