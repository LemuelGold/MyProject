<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conferences</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f5f5f5; }
        .sidebar { background: white; border-right: 2px solid #ddd; min-height: 100vh; }
        .sidebar-menu a { display: block; padding: 12px 20px; color: #666; text-decoration: none; font-weight: 500; transition: all 0.2s; font-size: 0.95rem; }
        .sidebar-menu a:hover, .sidebar-menu a.active { background-color: #f0f0f0; color: #333; }
        .page-title { background-color: #ddd; border-radius: 8px; }
        .form-control, .form-select { border: 2px solid #ddd; background-color: #f0f0f0; font-size: 0.9rem; }
        .form-control:focus, .form-select:focus { border-color: #666; box-shadow: none; background-color: white; }
        .btn-submit { background-color: #333; color: white; font-weight: 600; }
        .btn-submit:hover { background-color: #555; color: white; }
    </style>
</head>
<body>
<?php $active = 'conferences'; ?>
<div class="container-fluid">
    <div class="row g-0">
        <?= view('partials/sidebar') ?>

        <div class="col-md-10 p-4">
            <h1 class="page-title text-center fw-bold text-dark py-3 px-4 mb-4" style="font-size:1.5rem;">Conferences</h1>

            <div class="bg-white border rounded-3 p-4 mx-auto" style="max-width:900px;border:2px solid #ddd!important;">
                <?php
                $role   = strtolower(session('role') ?? 'admin');
                $prefix = $role === 'secretary' ? 'secretary' : 'admin';
                $db = \Config\Database::connect();
                $violations = $db->table('violations')->get()->getResultArray();
                ?>
                <form action="<?= base_url($prefix . '/conferences/save') ?>" method="post">
                    <?= csrf_field() ?>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark" style="font-size:0.9rem;">Students and Faculty</label>
                            <select class="form-select" id="user_type" name="user_type" required onchange="toggleUserType()">
                                <option value="" selected>Select</option>
                                <option value="Students">Students</option>
                                <option value="Faculty">Faculty</option>
                                <option value="Personnel">Personnel</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label class="form-label fw-semibold text-dark" style="font-size:0.9rem;">Name</label>
                            <div id="name-fields">
                                <div class="student-row border rounded p-3 mb-3" id="student-rows" style="display:none;">
                                    <div class="row mb-2 align-items-center g-2">
                                        <div class="col-md-3"><input type="text" class="form-control" name="names[]" placeholder="Name"></div>
                                        <div class="col-md-3"><input type="text" class="form-control" name="student_ids[]" placeholder="Student ID Number"></div>
                                        <div class="col-md-2">
                                            <select class="form-select" name="courses[]">
                                                <option value="">Course</option>
                                                <option>BSIT</option><option>BSCS</option><option>BSED</option>
                                                <option>BEED</option><option>BSA</option><option>BSHM</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <select class="form-select" name="year_levels[]">
                                                <option value="">Year</option>
                                                <option value="1">1st Year</option><option value="2">2nd Year</option>
                                                <option value="3">3rd Year</option><option value="4">4th Year</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <button type="button" class="btn btn-outline-secondary w-100" onclick="addStudentRow()">+</button>
                                        </div>
                                    </div>
                                    <div class="row g-2">
                                        <div class="col-md-6">
                                            <select class="form-select" name="violation_ids[]">
                                                <option value="">Select Violation</option>
                                                <?php foreach ($violations as $v): ?>
                                                    <option value="<?= $v['id'] ?>"><?= $v['violation_name'] ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <textarea class="form-control" name="descriptions[]" placeholder="Description (Optional)" rows="2"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div id="faculty-rows" style="display:none;">
                                    <div class="row mb-2 name-row align-items-center g-2">
                                        <div class="col-md-6"><input type="text" class="form-control faculty-name" name="names[]" placeholder="Name"></div>
                                        <div class="col-md-2"><button type="button" class="btn btn-outline-secondary w-100" onclick="addFacultyRow()">+</button></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold text-dark" style="font-size:0.9rem;">Date And Time</label>
                            <input type="datetime-local" class="form-control" name="date_time" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold text-dark" style="font-size:0.9rem;">Semester</label>
                            <select class="form-select" name="semester" required>
                                <option value="">Select</option>
                                <option>1st Semester</option><option>2nd Semester</option><option>Summer</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold text-dark" style="font-size:0.9rem;">School Year</label>
                            <select class="form-select" name="school_year" required>
                                <option value="">Select</option>
                                <option>2023-2024</option><option>2024-2025</option><option>2025-2026</option>
                                <option>2026-2027</option><option>2027-2028</option>
                            </select>
                        </div>
                    </div>

                    <div id="shared-violation-section">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold text-dark" style="font-size:0.9rem;">Violation</label>
                                <select class="form-select" id="shared_violation_id" name="shared_violation_id">
                                    <option value="">Select</option>
                                    <?php foreach ($violations as $v): ?>
                                        <option value="<?= $v['id'] ?>"><?= $v['violation_name'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold text-dark" style="font-size:0.9rem;">Phases</label>
                                <select class="form-select" id="phase" name="phase" required>
                                    <option value="">Select</option>
                                    <option>Phase 1</option><option>Phase 2</option><option>Phase 3</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-semibold text-dark" style="font-size:0.9rem;">Description / Optional</label>
                                <textarea class="form-control" id="shared_description" name="shared_description" placeholder="Description" rows="4"></textarea>
                            </div>
                        </div>
                    </div>

                    <div id="student-phase-section" style="display:none;">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold text-dark" style="font-size:0.9rem;">Phases</label>
                                <select class="form-select" id="phase_student" name="phase">
                                    <option value="">Select</option>
                                    <option>Phase 1</option><option>Phase 2</option><option>Phase 3</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-submit px-4 py-2 mt-3">Submit Conference</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const violationOptions = `<?php foreach ($violations as $v): ?><option value="<?= $v['id'] ?>"><?= $v['violation_name'] ?></option><?php endforeach; ?>`;

    function toggleUserType() {
        var t = document.getElementById('user_type').value;
        document.getElementById('student-rows').style.display   = t==='Students' ? 'block' : 'none';
        document.getElementById('faculty-rows').style.display   = (t==='Faculty'||t==='Personnel') ? 'block' : 'none';
        document.getElementById('shared-violation-section').style.display = t==='Students' ? 'none' : 'block';
        document.getElementById('student-phase-section').style.display   = t==='Students' ? 'block' : 'none';
    }

    function addStudentRow() {
        var nf = document.getElementById('name-fields');
        var row = document.createElement('div');
        row.className = 'student-row border rounded p-3 mb-3';
        row.innerHTML = `<div class="row mb-2 align-items-center g-2">
            <div class="col-md-3"><input type="text" class="form-control" name="names[]" placeholder="Name" required></div>
            <div class="col-md-3"><input type="text" class="form-control" name="student_ids[]" placeholder="Student ID Number" required></div>
            <div class="col-md-2"><select class="form-select" name="courses[]" required><option value="">Course</option><option>BSIT</option><option>BSCS</option><option>BSED</option><option>BEED</option><option>BSA</option><option>BSHM</option></select></div>
            <div class="col-md-2"><select class="form-select" name="year_levels[]" required><option value="">Year</option><option value="1">1st Year</option><option value="2">2nd Year</option><option value="3">3rd Year</option><option value="4">4th Year</option></select></div>
            <div class="col-md-2"><button type="button" class="btn btn-outline-danger w-100" onclick="removeStudentRow(this)">-</button></div>
        </div>
        <div class="row g-2">
            <div class="col-md-6"><select class="form-select" name="violation_ids[]" required><option value="">Select Violation</option>${violationOptions}</select></div>
            <div class="col-md-6"><textarea class="form-control" name="descriptions[]" placeholder="Description (Optional)" rows="2"></textarea></div>
        </div>`;
        nf.insertBefore(row, document.getElementById('faculty-rows'));
    }

    function removeStudentRow(btn) {
        var nf = document.getElementById('name-fields');
        if (nf.querySelectorAll('.student-row').length > 1) btn.closest('.student-row').remove();
    }

    function addFacultyRow() {
        var fr = document.getElementById('faculty-rows');
        var row = document.createElement('div');
        row.className = 'row mb-2 name-row align-items-center g-2';
        row.innerHTML = `<div class="col-md-6"><input type="text" class="form-control faculty-name" name="names[]" placeholder="Name" required></div>
            <div class="col-md-2"><button type="button" class="btn btn-outline-danger w-100" onclick="removeFacultyRow(this)">-</button></div>`;
        fr.appendChild(row);
    }

    function removeFacultyRow(btn) {
        var fr = document.getElementById('faculty-rows');
        if (fr.querySelectorAll('.name-row').length > 1) btn.closest('.name-row').remove();
    }
</script>
</body>
</html>
