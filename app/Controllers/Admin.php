<?php

namespace App\Controllers;

class Admin extends BaseController
{
    public function index()
    {
        return view('auth/dashboard');
    }

    public function conferences()
    {
        return view('admin/conferences');
    }

    public function conferenceRecords()
    {
        return view('admin/conference_records');
    }

    public function studentViolation()
    {
        return view('admin/student_violation');
    }

    public function saveStudentViolation()
    {
        $db = \Config\Database::connect();
        
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

    public function saveConference()
    {
        $db = \Config\Database::connect();

        $userType    = $this->request->getPost('user_type');
        $names       = $this->request->getPost('names') ?? [];
        $studentIds  = $this->request->getPost('student_ids') ?? [];
        $courses     = $this->request->getPost('courses') ?? [];
        $yearLevels  = $this->request->getPost('year_levels') ?? [];
        $violationIds = $this->request->getPost('violation_ids') ?? [];
        $descriptions = $this->request->getPost('descriptions') ?? [];
        $dateTime    = $this->request->getPost('date_time');
        $semester    = $this->request->getPost('semester');
        $schoolYear  = $this->request->getPost('school_year');
        $phase       = $this->request->getPost('phase');

        // Shared violation/description for Faculty/Personnel
        $sharedViolationId  = $this->request->getPost('shared_violation_id');
        $sharedDescription  = $this->request->getPost('shared_description');

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

    public function updateViolationRecord()
    {
        $db       = \Config\Database::connect();
        $id       = $this->request->getPost('id');
        $newPhase = $this->request->getPost('phase');

        $original = $db->table('violation_records')->where('id', $id)->get()->getRowArray();

        if ($original && $newPhase !== $original['phase']) {
            // Phase changed — insert a new row, leave the original intact
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
            // Same phase — just update in place
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

    public function userManagement()
    {
        $db    = \Config\Database::connect();
        $users = $db->table('users')->get()->getResultArray();
        return view('admin/user_management', ['users' => $users]);
    }

    public function saveUser()
    {
        $db       = \Config\Database::connect();
        $password = $this->request->getPost('password');

        $db->table('users')->insert([
            'username'   => $this->request->getPost('username'),
            'email'      => $this->request->getPost('email'),
            'password'   => password_hash($password, PASSWORD_DEFAULT),
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
        $db = \Config\Database::connect();
        $id = $this->request->getPost('id');

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
        $db = \Config\Database::connect();
        $id = $this->request->getPost('id');
        $db->table('users')->where('id', $id)->delete();
        return redirect()->to(base_url('admin/user-management'))->with('success', 'User deleted.');
    }

    public function violationRecords()
    {
        $db = \Config\Database::connect();

        $all = $db->table('violation_records vr')
            ->select('vr.*, v.violation_name')
            ->join('violations v', 'v.id = vr.violation_id', 'left')
            ->orderBy('vr.student_id')->orderBy('vr.phase', 'ASC')->orderBy('vr.created_at', 'ASC')
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

        return view('admin/violation_records', ['grouped' => $grouped]);
    }

    // Secretary — same pages, no user management
    public function secretaryDashboard()
    {
        return view('auth/dashboard');
    }

    public function secretaryConferences()
    {
        return view('admin/conferences');
    }

    public function secretaryConferenceRecords()
    {
        return view('admin/conference_records');
    }

    public function secretaryStudentViolation()
    {
        return view('admin/student_violation');
    }

    public function secretaryViolationRecords()
    {
        $db = \Config\Database::connect();

        $all = $db->table('violation_records vr')
            ->select('vr.*, v.violation_name')
            ->join('violations v', 'v.id = vr.violation_id', 'left')
            ->orderBy('vr.student_id')->orderBy('vr.phase', 'ASC')->orderBy('vr.created_at', 'ASC')
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

        return view('admin/violation_records', ['grouped' => $grouped]);
    }
}


