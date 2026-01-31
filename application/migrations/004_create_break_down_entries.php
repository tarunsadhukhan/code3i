<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_break_down_entries extends CI_Migration {

    public function up()
    {
        $this->dbforge->add_field(array(
            'bkd_id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => TRUE
            ),
            'tran_date' => array(
                'type' => 'DATE'
            ),
            'spell' => array(
                'type' => 'VARCHAR',
                'constraint' => 2
            ),
            'time_from' => array(
                'type' => 'VARCHAR',
                'constraint' => 6
            ),
            'time_to' => array(
                'type' => 'VARCHAR',
                'constraint' => 6
            ),
            'total_hours' => array(
                'type' => 'DECIMAL',
                'constraint' => '6,2'
            ),
            'remarks' => array(
                'type' => 'VARCHAR',
                'constraint' => 60
            ),
            'mechine_id' => array(
                'type' => 'INT',
                'constraint' => 11
            ),
            'co_id' => array(
                'type' => 'INT',
                'constraint' => 11
            ),
            'is_active' => array(
                'type' => 'INT',
                'constraint' => 1,
                'default' => 1
            ),
            'updated_by' => array(
                'type' => 'INT',
                'constraint' => 11
            ),
            'updated_date_time' => array(
                'type' => 'TIMESTAMP',
                'default' => 'CURRENT_TIMESTAMP',
                'on_update' => 'CURRENT_TIMESTAMP'
            )
        ));
        $this->dbforge->add_key('bkd_id', TRUE);
        $this->dbforge->create_table('EMPMILL12.break_down_entries');
    }

    public function down()
    {
        $this->dbforge->drop_table('EMPMILL12.break_down_entries');
    }
}
