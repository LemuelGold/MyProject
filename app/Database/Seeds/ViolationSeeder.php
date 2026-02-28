<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ViolationSeeder extends Seeder
{
    public function run()
    {
        // Clear existing data first to avoid duplicates
        $this->db->table('violations')->truncate();
        
        $data = [
            ['violation_name' => 'Bringing a weapon on campus', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['violation_name' => 'Bringing a vape/cigarettes on campus', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['violation_name' => 'Improper Uniform', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['violation_name' => 'Disrespect to Teacher', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['violation_name' => 'No ID', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['violation_name' => 'Fighting', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['violation_name' => 'Vandalism', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['violation_name' => 'Harassment', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
        ];

        $this->db->table('violations')->insertBatch($data);
    }
}
