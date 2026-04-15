<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Violation Records</title>
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
        .phase-badge { display: inline-block; padding: 4px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: 700; color: #fff; }
        .phase-1 { background-color: #e6a817; }
        .phase-2 { background-color: #e8722a; }
        .phase-3 { background-color: #dc3545; }
        .btn-view-rec { background-color: #333; color: white; border: none; border-radius: 4px; padding: 4px 12px; font-size: 0.82rem; font-weight: 600; }
        .btn-view-rec:hover { background-color: #555; color: white; }
        .btn-edit-rec { background-color: #2563a8; color: white; border: none; border-radius: 4px; padding: 4px 12px; font-size: 0.82rem; font-weight: 600; }
        .btn-edit-rec:hover { background-color: #1a4a80; color: white; }
        .modal-label { font-weight: 600; color: #555; font-size: 0.85rem; }
        .modal-value { background-color: #f0f0f0; border: 2px solid #ddd; border-radius: 5px; padding: 7px 12px; font-size: 0.9rem; min-height: 38px; }
    </style>
</head>
<body>
<?php $active = 'violation-records'; ?>
<div class="container-fluid">
    <div class="row g-0">
        <?= view('partials/sidebar') ?>

        <div class="col-md-10 p-4">
            <h1 class="page-title text-center fw-bold text-dark py-3 px-4 mb-4" style="font-size:1.5rem;">Violation Records</h1>

            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
            <?php endif; ?>

            <!-- Filter Bar -->
            <div class="bg-white border rounded-3 p-3 mb-3" style="border:2px solid #ddd!important;">
                <div class="row align-items-end g-3">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold" style="font-size:0.85rem;">Search</label>
                        <input type="text" id="searchInput" class="form-control" placeholder="Search name, student ID, violation...">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold" style="font-size:0.85rem;">Year Level</label>
                        <select id="yearFilter" class="form-select">
                            <option value="">All</option>
                            <option value="1">1st Year</option><option value="2">2nd Year</option>
                            <option value="3">3rd Year</option><option value="4">4th Year</option>
                        </select>
                    </div>
                </div>
            </div>

            <?php
            $role   = strtolower(session('user_role') ?? 'admin');
            $prefix = $role === 'secretary' ? 'secretary' : 'admin';
            $db = \Config\Database::connect();
            $violations = $db->table('violations')->get()->getResultArray();
            ?>

            <?php if (empty($grouped)): ?>
                <div class="alert alert-info">No violation records found.</div>
            <?php else: ?>
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="recordsTable">
                    <thead>
                        <tr>
                            <th>#</th><th>Name</th><th>Student ID</th><th>Course</th><th>Year Level</th>
                            <th>Violation</th><th>Phase</th><th>Semester</th><th>School Year</th><th>Date & Time</th><th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                        <?php $i = 1; foreach ($grouped as $group):
                            $record = $group['latest'];
                            $history = $group['history'];
                            $phaseClass = 'phase-1';
                            if ($record['phase'] === 'Phase 2') $phaseClass = 'phase-2';
                            elseif ($record['phase'] === 'Phase 3') $phaseClass = 'phase-3';
                        ?>
                        <tr data-name="<?= strtolower(esc($record['name'])) ?>"
                            data-studentid="<?= strtolower(esc($record['student_id'] ?? '')) ?>"
                            data-violation="<?= strtolower(esc($record['violation_name'])) ?>"
                            data-year="<?= esc($record['year_level'] ?? '') ?>">
                            <td><?= $i++ ?></td>
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
                                        'history'    => array_map(fn($h) => [
                                            'violation'   => $h['violation_name'],
                                            'phase'       => $h['phase'],
                                            'semester'    => $h['semester'],
                                            'school_year' => $h['school_year'],
                                            'date_time'   => date('M d, Y h:i A', strtotime($h['date_time'])),
                                            'description' => $h['description'] ?? '-',
                                        ], $history),
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

<!-- VIEW Modal -->
<div class="modal fade" id="viewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#333;color:white;">
                <h5 class="modal-title">Violation Record Details</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-md-6"><div class="modal-label mb-1">Name</div><div class="modal-value" id="v-name"></div></div>
                    <div class="col-md-6"><div class="modal-label mb-1">Student ID</div><div class="modal-value" id="v-studentid"></div></div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-6"><div class="modal-label mb-1">Course</div><div class="modal-value" id="v-course"></div></div>
                    <div class="col-md-6"><div class="modal-label mb-1">Year Level</div><div class="modal-value" id="v-year"></div></div>
                </div>
                <hr>
                <div id="v-history"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- EDIT Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#2563a8;color:white;">
                <h5 class="modal-title">Edit Violation Record</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= base_url($prefix . '/violation-records/update') ?>" method="post">
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
                                <option>Phase 1</option><option>Phase 2</option><option>Phase 3</option>
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
                    <button type="submit" class="btn fw-semibold text-white" style="background-color:#2563a8;">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function filterTable() {
        var search = document.getElementById('searchInput').value.toLowerCase();
        var year   = document.getElementById('yearFilter').value;
        document.querySelectorAll('#tableBody tr').forEach(function(row) {
            var matchSearch = !search || (row.dataset.name||'').includes(search) || (row.dataset.studentid||'').includes(search) || (row.dataset.violation||'').includes(search);
            var matchYear   = !year || (row.dataset.year||'') === year;
            row.style.display = (matchSearch && matchYear) ? '' : 'none';
        });
    }
    document.getElementById('searchInput').addEventListener('input', filterTable);
    document.getElementById('yearFilter').addEventListener('change', filterTable);

    function viewRecord(data) {
        document.getElementById('v-name').textContent      = data.name;
        document.getElementById('v-studentid').textContent = data.student_id;
        document.getElementById('v-course').textContent    = data.course;
        document.getElementById('v-year').textContent      = data.year_level;
        var phaseColors = {'Phase 1':'#e6a817','Phase 2':'#e8722a','Phase 3':'#dc3545'};
        var html = '';
        data.history.forEach(function(h) {
            var c = phaseColors[h.phase] || '#333';
            html += '<div style="border:2px solid '+c+';border-radius:8px;padding:14px 16px;margin-bottom:14px;">';
            html += '<div style="font-weight:700;color:'+c+';font-size:0.95rem;margin-bottom:10px;">'+h.phase+'</div>';
            html += '<div class="row g-2"><div class="col-md-6"><div class="modal-label mb-1">Violation</div><div class="modal-value">'+h.violation+'</div></div>';
            html += '<div class="col-md-6"><div class="modal-label mb-1">Date & Time</div><div class="modal-value">'+h.date_time+'</div></div></div>';
            html += '<div class="row g-2 mt-1"><div class="col-md-6"><div class="modal-label mb-1">Semester</div><div class="modal-value">'+h.semester+'</div></div>';
            html += '<div class="col-md-6"><div class="modal-label mb-1">School Year</div><div class="modal-value">'+h.school_year+'</div></div></div>';
            html += '<div class="row g-2 mt-1"><div class="col-md-12"><div class="modal-label mb-1">Description</div><div class="modal-value">'+(h.description||'-')+'</div></div></div></div>';
        });
        document.getElementById('v-history').innerHTML = html;
        new bootstrap.Modal(document.getElementById('viewModal')).show();
    }

    function editRecord(data) {
        document.getElementById('edit-id').value          = data.id;
        document.getElementById('edit-violation').value   = data.violation_id;
        document.getElementById('edit-phase').value       = data.phase;
        document.getElementById('edit-datetime').value    = data.date_time ? data.date_time.slice(0,16) : '';
        document.getElementById('edit-description').value = data.description;
        new bootstrap.Modal(document.getElementById('editModal')).show();
    }
</script>
</body>
</html>

