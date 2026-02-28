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

    public function violationRecords()
    {
        return view('admin/violation_records');
    }
}
