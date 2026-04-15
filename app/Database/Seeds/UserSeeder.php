<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'username'   => 'Director',
                'email'      => 'admin@gmail.com',
                'password'   => password_hash('admin123', PASSWORD_DEFAULT),
                'first_name' => 'Admin',
                'last_name'  => 'User',
                'role'       => 'admin',
                'status'     => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'username'   => 'Secretary',
                'email'      => 'secretary@gmail.com',
                'password'   => password_hash('secretary123', PASSWORD_DEFAULT),
                'first_name' => 'Secretary',
                'last_name'  => 'User',
                'role'       => 'secretary',
                'status'     => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
          
        ];

        $this->db->table('users')->insertBatch($data);
    }
}
