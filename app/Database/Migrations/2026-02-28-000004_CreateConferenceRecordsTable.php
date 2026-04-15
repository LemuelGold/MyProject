<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateConferenceRecordsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'           => ['type' => 'INT', 'auto_increment' => true],
            'user_type'    => ['type' => 'VARCHAR', 'constraint' => 50],
            'name'         => ['type' => 'VARCHAR', 'constraint' => 255],
            'student_id'   => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'course'       => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'year_level'   => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'date_time'    => ['type' => 'DATETIME', 'null' => true],
            'semester'     => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'school_year'  => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
            'violation_id' => ['type' => 'INT', 'null' => true],
            'phase'        => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'description'  => ['type' => 'TEXT', 'null' => true],
            'created_at'   => ['type' => 'DATETIME', 'null' => true],
            'updated_at'   => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('conference_records');
    }

    public function down()
    {
        $this->forge->dropTable('conference_records');
    }
}
