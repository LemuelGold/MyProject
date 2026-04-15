<?php

namespace App\Controllers;

class Admin extends BaseController
{
    // ─── Guards ──────────────────────────────────────────────────────────────

    private function requireLogin(): ?object
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to(base_url('auth/login'));
        }
        return null;
    }

    private function requireAdmin(): ?object
    {
        if ($r = $this->requireLogin()) return $r;
        if (session()->get('user_role') !== 'admin') {
            return redirect()->to(base_url('dashboard'));
        }
        return null;
    }

    private function requireAdminOrSecretary(): ?object
    {
        if ($r = $this->requireLogin()) return $r;
        $role = session()->get('user_role');
        if (!in_array($role, ['admin', 'secretary'])) {
            return redirect()->to(base_url('dashboard'));
        }
        return null;
    }

    // ─── Shared violation records logic ──────────────────────────────────────

    private function getGroupedViolationRecords(): array
    {
        $db  = \Config\Database::connect();
        $all = $db->table('violation_records vr')
            ->select('vr.*, v.violation_name')
            ->join('violations v', 'v.id = vr.violation_id', 'left')
            ->orderBy('vr.student_id')
            ->orderBy('vr.phase', 'ASC')
            ->orderBy('vr.created_at', 'ASC')
            ->get()->getResultArray();

        $grouped    = [];
        $phaseOrder = ['Phase 1' => 1, 'Phase 2' => 2, 'Phase 3' => 3];
        foreach ($all as $row) {
            $key = $row['student_id'] ?: $row['name'];
            if (!isset($grouped[$key])) {
                $grouped[$key] = ['latest' => $row, 'history' => []];
            }
            $grouped[$key]['history'][] = $row;
            $currentOrder = $phaseOrder[$grouped[$key]['latest']['phase']] ?? 0;
            $rowOrder     = $phaseOrder[$row['phase']] ?? 0;
            if ($rowOrder >= $currentOrder) {
                $grouped[$key]['latest'] = $row;
            }
        }
        return $grouped;
    }

    // ─── Dashboard ───────────────────────────────────────────────────────────

    public function index()
    {
        if ($r = $this->requireAdminOrSecretary()) return $r;
        return view('auth/dashboard');
    }

    // ─── Conferences ─────────────────────────────────────────────────────────

    public function conferences()
    {
        if ($r = $this->requireAdminOrSecretary()) return $r;
        return view('admin/conferences');
    }

    public function saveConference()
    {
        if ($r = $this->requireAdminOrSecretary()) return $r;

        $db           = \Config\Database::connect();
        $userType     = $this->request->getPost('user_type');
        $names        = $this->request->getPost('names') ?? [];
        $studentIds   = $this->request->getPost('student_ids') ?? [];
        $courses      = $this->request->getPost('courses') ?? [];
        $yearLevels   = $this->request->getPost('year_levels') ?? [];
        $violationIds = $this->request->getPost('violation_ids') ?? [];
        $descriptions = $this->request->getPost('descriptions') ?? [];
        $dateTime     = $this->request->getPost('date_time');
        $semester     = $this->request->getPost('semester');
        $schoolYear   = $this->request->getPost('school_year');
        $phase        = $this->request->getPost('phase');
        $sharedViolationId = $this->request->getPost('shared_violation_id');
        $sharedDescription = $this->request->getPost('shared_description');

        foreach ($names as $index => $name) {
            if (empty(trim($name))) continue;
            $isStudent = $userType === 'Students';
            $db->table('conference_records')->insert([
                'user_type'    => $userType,
                'name'         => $name,
                'student_id'   => $isStudent ? ($studentIds[$index] ?? null) : null,
                'course'       => $isStudent ? ($courses[$index] ?? null) : null,
                'year_level'   => $isStudent ? ($yearLevels[$index] ?? null) : null,
                'date_time'    => $dateTime,
                'semester'     => $semester,
                'school_year'  => $schoolYear,
                'violation_id' => $isStudent ? ($violationIds[$index] ?? null) : $sharedViolationId,
                'phase'        => $phase,
                'description'  => $isStudent ? ($descriptions[$index] ?? null) : $sharedDescription,
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ]);
        }

        return redirect()->to(base_url('admin/conference-records'))->with('success', 'Conference record saved successfully.');
    }

    // ─── Conference Records ───────────────────────────────────────────────────

    public function conferenceRecords()
    {
        if ($r = $this->requireAdminOrSecretary()) return $r;
        return view('admin/conference_records');
    }

    // ─── Student Violation ────────────────────────────────────────────────────

    public function studentViolation()
    {
        if ($r = $this->requireAdminOrSecretary()) return $r;
        return view('admin/student_violation');
    }

    public function saveStudentViolation()
    {
        if ($r = $this->requireAdminOrSecretary()) return $r;

        $db           = \Config\Database::connect();
        $names        = $this->request->getPost('names');
        $studentIds   = $this->request->getPost('student_ids') ?? [];
        $courses      = $this->request->getPost('courses') ?? [];
        $yearLevels   = $this->request->getPost('year_levels') ?? [];
        $violationIds = $this->request->getPost('violation_ids') ?? [];
        $descriptions = $this->request->getPost('descriptions') ?? [];
        $dateTime     = $this->request->getPost('date_time');
        $semester     = $this->request->getPost('semester');
        $schoolYear   = $this->request->getPost('school_year');
        $phase        = $this->request->getPost('phase');

        foreach ($names as $index => $name) {
            if (empty(trim($name))) continue;
            $db->table('violation_records')->insert([
                'name'         => $name,
                'student_id'   => $studentIds[$index] ?? null,
                'course'       => $courses[$index] ?? null,
                'year_level'   => $yearLevels[$index] ?? null,
                'date_time'    => $dateTime,
                'semester'     => $semester,
                'school_year'  => $schoolYear,
                'violation_id' => $violationIds[$index] ?? null,
                'phase'        => $phase,
                'description'  => $descriptions[$index] ?? null,
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ]);
        }

        return redirect()->to(base_url('admin/violation-records'))->with('success', 'Violation record saved successfully.');
    }

    // ─── Violation Records ────────────────────────────────────────────────────

    public function violationRecords()
    {
        if ($r = $this->requireAdminOrSecretary()) return $r;
        return view('admin/violation_records', ['grouped' => $this->getGroupedViolationRecords()]);
    }

    public function updateViolationRecord()
    {
        if ($r = $this->requireAdminOrSecretary()) return $r;

        $db       = \Config\Database::connect();
        $id       = $this->request->getPost('id');
        $newPhase = $this->request->getPost('phase');
        $original = $db->table('violation_records')->where('id', $id)->get()->getRowArray();

        if ($original && $newPhase !== $original['phase']) {
            $db->table('violation_records')->insert([
                'name'         => $original['name'],
                'student_id'   => $original['student_id'],
                'course'       => $original['course'],
                'year_level'   => $original['year_level'],
                'semester'     => $original['semester'],
                'school_year'  => $original['school_year'],
                'violation_id' => $this->request->getPost('violation_id'),
                'phase'        => $newPhase,
                'date_time'    => $this->request->getPost('date_time'),
                'description'  => $this->request->getPost('description'),
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ]);
        } else {
            $db->table('violation_records')->where('id', $id)->update([
                'violation_id' => $this->request->getPost('violation_id'),
                'phase'        => $newPhase,
                'date_time'    => $this->request->getPost('date_time'),
                'description'  => $this->request->getPost('description'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ]);
        }

        return redirect()->to(base_url('admin/violation-records'))->with('success', 'Record updated successfully.');
    }

    // ─── User Management (Admin only) ─────────────────────────────────────────

    public function userManagement()
    {
        if ($r = $this->requireAdmin()) return $r;
        $db    = \Config\Database::connect();
        $users = $db->table('users')->get()->getResultArray();
        return view('admin/user_management', ['users' => $users]);
    }

    public function saveUser()
    {
        if ($r = $this->requireAdmin()) return $r;
        $db = \Config\Database::connect();
        $db->table('users')->insert([
            'username'   => $this->request->getPost('username'),
            'email'      => $this->request->getPost('email'),
            'password'   => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'first_name' => $this->request->getPost('first_name'),
            'last_name'  => $this->request->getPost('last_name'),
            'role'       => $this->request->getPost('role'),
            'status'     => 'active',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        return redirect()->to(base_url('admin/user-management'))->with('success', 'User created successfully.');
    }

    public function updateUser()
    {
        if ($r = $this->requireAdmin()) return $r;
        $db   = \Config\Database::connect();
        $id   = $this->request->getPost('id');
        $data = [
            'username'   => $this->request->getPost('username'),
            'email'      => $this->request->getPost('email'),
            'first_name' => $this->request->getPost('first_name'),
            'last_name'  => $this->request->getPost('last_name'),
            'role'       => $this->request->getPost('role'),
            'status'     => $this->request->getPost('status'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];
        $password = $this->request->getPost('password');
        if (!empty($password)) {
            $data['password'] = password_hash($password, PASSWORD_DEFAULT);
        }
        $db->table('users')->where('id', $id)->update($data);
        return redirect()->to(base_url('admin/user-management'))->with('success', 'User updated successfully.');
    }

    public function deleteUser()
    {
        if ($r = $this->requireAdmin()) return $r;
        $db = \Config\Database::connect();
        $db->table('users')->where('id', $this->request->getPost('id'))->delete();
        return redirect()->to(base_url('admin/user-management'))->with('success', 'User deleted.');
    }
}
