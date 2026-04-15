<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Violation Records</title>
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
        .sidebar-title { font-size: 1.5rem; font-weight: 700; padding: 0 20px; margin-bottom: 30px; color: #333; }
        .sidebar-menu { list-style: none; padding: 0; margin: 0; }
        .sidebar-menu li { margin-bottom: 5px; }
        .sidebar-menu a {
            display: block; padding: 12px 20px; color: #666;
            text-decoration: none; font-weight: 500; transition: all 0.2s;
        }
        .sidebar-menu a:hover, .sidebar-menu a.active { background-color: #f0f0f0; color: #333; }
        .main-content { padding: 30px; }
        .page-title {
            font-size: 1.5rem; font-weight: 700; color: #333; text-align: center;
            background-color: #ddd; padding: 15px; border-radius: 8px; margin-bottom: 30px;
        }
        .table th { background-color: #333; color: white; font-size: 0.85rem; }
        .table td { font-size: 0.85rem; vertical-align: middle; }
        .filter-bar {
            background: white; border: 2px solid #ddd; border-radius: 8px;
            padding: 15px 20px; margin-bottom: 20px;
        }
        .form-control, .form-select {
            border: 2px solid #ddd; border-radius: 5px;
            font-size: 0.9rem; background-color: #f0f0f0;
        }
        .form-control:focus, .form-select:focus {
            border-color: #666; box-shadow: none; background-color: white;
        }
        /* Phase badges */
        .phase-badge {
            display: inline-block; padding: 4px 12px; border-radius: 20px;
            font-size: 0.8rem; font-weight: 700; color: #fff;
        }
        .phase-1 { background-color: #e6a817; color: #fff; }
        .phase-2 { background-color: #e8722a; color: #fff; }
        .phase-3 { background-color: #dc3545; color: #fff; }
        /* Buttons */
        .btn-view-rec {
            background-color: #333; color: white; border: none;
            border-radius: 4px; padding: 4px 12px; font-size: 0.82rem; font-weight: 600;
        }
        .btn-view-rec:hover { background-color: #555; color: white; }
        .btn-edit-rec {
            background-color: #2563a8; color: white; border: none;
            border-radius: 4px; padding: 4px 12px; font-size: 0.82rem; font-weight: 600;
        }
        .btn-edit-rec:hover { background-color: #1a4a80; color: white; }
        /* Modal read-only fields */
        .modal-label { font-weight: 600; color: #555; font-size: 0.85rem; }
        .modal-value {
            background-color: #f0f0f0; border: 2px solid #ddd; border-radius: 5px;
            padding: 7px 12px; font-size: 0.9rem; min-height: 38px;
        }
        .modal-value.desc { min-height: 70px; }
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
                <li><a href="<?= base_url('admin/conference-records') ?>">Conference Records</a></li>
                <li><a href="<?= base_url('admin/student-violation') ?>">Student Violation</a></li>
                <li><a href="<?= base_url('admin/violation-records') ?>" class="active">Violation Records</a></li>
                <li><a href="<?= base_url('auth/login') ?>" style="color:#999;margin-top:20px;">Logout</a></li>
            </ul>
        </div>

        <div class="col-md-10 main-content">
            <h1 class="page-title">Violation Records</h1>

            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
            <?php endif; ?>

            <!-- Filter Bar -->
            <div class="filter-bar">
                <div class="row align-items-end g-3">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold" style="font-size:0.85rem;">Search</label>
                        <input type="text" id="searchInput" class="form-control" placeholder="Search name, student ID, violation...">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold" style="font-size:0.85rem;">Year Level</label>
                        <select id="yearFilter" class="form-select">
                            <option value="">All</option>
                            <option value="1">1st Year</option>
                            <option value="2">2nd Year</option>
                            <option value="3">3rd Year</option>
                            <option value="4">4th Year</option>
                        </select>
                    </div>
                </div>
            </div>

            <?php
            $db = \Config\Database::connect();
            $violations = $db->table('violations')->get()->getResultArray();
            ?>

            <?php if (empty($records)): ?>
                <div class="alert alert-info">No violation records found.</div>
            <?php else: ?>
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="recordsTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Student ID</th>
                            <th>Course</th>
                            <th>Year Level</th>
                            <th>Violation</th>
                            <th>Phase</th>
                            <th>Semester</th>
                            <th>School Year</th>
                            <th>Date & Time</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                        <?php foreach ($records as $i => $record):
                            $phaseClass = 'phase-1';
                            if ($record['phase'] === 'Phase 2') $phaseClass = 'phase-2';
                            elseif ($record['phase'] === 'Phase 3') $phaseClass = 'phase-3';
                        ?>
                        <tr
                            data-name="<?= strtolower(esc($record['name'])) ?>"
                            data-studentid="<?= strtolower(esc($record['student_id'] ?? '')) ?>"
                            data-violation="<?= strtolower(esc($record['violation_name'])) ?>"
                            data-year="<?= esc($record['year_level'] ?? '') ?>"
                        >
                            <td><?= $i + 1 ?></td>
                            <td><?= esc($record['name']) ?></td>
                            <td><?= esc($record['student_id'] ?? '-') ?></td>
                            <td><?= esc($record['course'] ?? '-') ?></td>
                            <td><?= esc($record['year_level'] ?? '-') ?></td>
                            <td><?= esc($record['violation_name']) ?></td>
                            <td><span class="phase-badge <?= $phaseClass ?>"><?= esc($record['phase']) ?></span></td>
                            <td><?= esc($record['semester']) ?></td>
                            <td><?= esc($record['school_year']) ?></td>
                            <td><?= date('M d, Y h:i A', strtotime($record['date_time'])) ?></td>
                            <td style="white-space:nowrap;">
                                <button class="btn btn-view-rec me-1"
                                    onclick="viewRecord(<?= htmlspecialchars(json_encode([
                                        'name'       => $record['name'],
                                        'student_id' => $record['student_id'] ?? '-',
                                        'course'     => $record['course'] ?? '-',
                                        'year_level' => $record['year_level'] ?? '-',
                                        'violation'  => $record['violation_name'],
                                        'phase'      => $record['phase'],
                                        'semester'   => $record['semester'],
                                        'school_year'=> $record['school_year'],
                                        'date_time'  => date('M d, Y h:i A', strtotime($record['date_time'])),
                                        'description'=> $record['description'] ?? '-',
                                    ]), ENT_QUOTES) ?>)">View</button>
                                <button class="btn btn-edit-rec"
                                    onclick="editRecord(<?= htmlspecialchars(json_encode([
                                        'id'           => $record['id'],
                                        'violation_id' => $record['violation_id'],
                                        'phase'        => $record['phase'],
                                        'date_time'    => $record['date_time'],
                                        'description'  => $record['description'] ?? '',
                                    ]), ENT_QUOTES) ?>)">Edit</button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- VIEW Modal (read-only) -->
<div class="modal fade" id="viewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#333;color:white;">
                <h5 class="modal-title">Violation Record Details</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="modal-label mb-1">Name</div>
                        <div class="modal-value" id="v-name"></div>
                    </div>
                    <div class="col-md-6">
                        <div class="modal-label mb-1">Student ID</div>
                        <div class="modal-value" id="v-studentid"></div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="modal-label mb-1">Course</div>
                        <div class="modal-value" id="v-course"></div>
                    </div>
                    <div class="col-md-6">
                        <div class="modal-label mb-1">Year Level</div>
                        <div class="modal-value" id="v-year"></div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="modal-label mb-1">Violation</div>
                        <div class="modal-value" id="v-violation"></div>
                    </div>
                    <div class="col-md-6">
                        <div class="modal-label mb-1">Phase</div>
                        <div class="modal-value" id="v-phase"></div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="modal-label mb-1">Semester</div>
                        <div class="modal-value" id="v-semester"></div>
                    </div>
                    <div class="col-md-6">
                        <div class="modal-label mb-1">School Year</div>
                        <div class="modal-value" id="v-schoolyear"></div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-12">
                        <div class="modal-label mb-1">Date & Time</div>
                        <div class="modal-value" id="v-datetime"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="modal-label mb-1">Description</div>
                        <div class="modal-value desc" id="v-description"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- EDIT Modal (only phase, violation, description, date/time) -->
<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#2563a8;color:white;">
                <h5 class="modal-title">Edit Violation Record</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= base_url('admin/violation-records/update') ?>" method="post">
                <?= csrf_field() ?>
                <input type="hidden" name="id" id="edit-id">
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="modal-label mb-1">Violation</label>
                            <select class="form-select" name="violation_id" id="edit-violation">
                                <option value="">Select Violation</option>
                                <?php foreach ($violations as $v): ?>
                                    <option value="<?= $v['id'] ?>"><?= esc($v['violation_name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="modal-label mb-1">Phase</label>
                            <select class="form-select" name="phase" id="edit-phase">
                                <option value="Phase 1">Phase 1</option>
                                <option value="Phase 2">Phase 2</option>
                                <option value="Phase 3">Phase 3</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label class="modal-label mb-1">Date & Time</label>
                            <input type="datetime-local" class="form-control" name="date_time" id="edit-datetime">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label class="modal-label mb-1">Description</label>
                            <textarea class="form-control" name="description" id="edit-description" rows="4" placeholder="Description (Optional)"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn" style="background-color:#2563a8;color:white;font-weight:600;">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Search + Year Level filter
    function filterTable() {
        var search = document.getElementById('searchInput').value.toLowerCase();
        var year   = document.getElementById('yearFilter').value;
        document.querySelectorAll('#tableBody tr').forEach(function(row) {
            var matchSearch = !search ||
                (row.dataset.name || '').includes(search) ||
                (row.dataset.studentid || '').includes(search) ||
                (row.dataset.violation || '').includes(search);
            var matchYear = !year || (row.dataset.year || '') === year;
            row.style.display = (matchSearch && matchYear) ? '' : 'none';
        });
    }
    document.getElementById('searchInput').addEventListener('input', filterTable);
    document.getElementById('yearFilter').addEventListener('change', filterTable);

    // View modal (read-only)
    function viewRecord(data) {
        document.getElementById('v-name').textContent        = data.name;
        document.getElementById('v-studentid').textContent   = data.student_id;
        document.getElementById('v-course').textContent      = data.course;
        document.getElementById('v-year').textContent        = data.year_level;
        document.getElementById('v-violation').textContent   = data.violation;
        document.getElementById('v-phase').textContent       = data.phase;
        document.getElementById('v-semester').textContent    = data.semester;
        document.getElementById('v-schoolyear').textContent  = data.school_year;
        document.getElementById('v-datetime').textContent    = data.date_time;
        document.getElementById('v-description').textContent = data.description;
        new bootstrap.Modal(document.getElementById('viewModal')).show();
    }

    // Edit modal (editable fields only)
    function editRecord(data) {
        document.getElementById('edit-id').value          = data.id;
        document.getElementById('edit-violation').value   = data.violation_id;
        document.getElementById('edit-phase').value       = data.phase;
        document.getElementById('edit-datetime').value    = data.date_time ? data.date_time.slice(0, 16) : '';
        document.getElementById('edit-description').value = data.description;
        new bootstrap.Modal(document.getElementById('editModal')).show();
    }
</script>
</body>
</html>
