<?php

namespace App\Controllers;

class Admin extends BaseController
{
    public function index()
    {
        return view('admin/dashboard');
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
        $db = \Config\Database::connect();
        $id = $this->request->getPost('id');

        $db->table('violation_records')->where('id', $id)->update([
            'violation_id' => $this->request->getPost('violation_id'),
            'phase'        => $this->request->getPost('phase'),
            'date_time'    => $this->request->getPost('date_time'),
            'description'  => $this->request->getPost('description'),
            'updated_at'   => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to(base_url('admin/violation-records'))->with('success', 'Record updated successfully.');
    }

    public function violationRecords()
    {
        $db = \Config\Database::connect();
        $records = $db->table('violation_records vr')
            ->select('vr.*, v.violation_name')
            ->join('violations v', 'v.id = vr.violation_id', 'left')
            ->orderBy('vr.created_at', 'DESC')
            ->get()->getResultArray();

        return view('admin/violation_records', ['records' => $records]);
    }
}
