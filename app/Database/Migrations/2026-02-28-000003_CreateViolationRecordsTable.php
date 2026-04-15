<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateViolationRecordsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'           => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'name'         => ['type' => 'VARCHAR', 'constraint' => 255],
            'student_id'   => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'course'       => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'year_level'   => ['type' => 'VARCHAR', 'constraint' => 10, 'null' => true],
            'date_time'    => ['type' => 'DATETIME'],
            'semester'     => ['type' => 'VARCHAR', 'constraint' => 50],
            'school_year'  => ['type' => 'VARCHAR', 'constraint' => 20],
            'violation_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'phase'        => ['type' => 'VARCHAR', 'constraint' => 50],
            'description'  => ['type' => 'TEXT', 'null' => true],
            'created_at'   => ['type' => 'DATETIME', 'null' => true],
            'updated_at'   => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('violation_records');
    }

    public function down()
    {
        $this->forge->dropTable('violation_records');
    }
}
