<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_spreader_lapping_entries extends CI_Migration {

    public function up()
    {
        $this->dbforge->add_field(array(
            'sprd_lapp_id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => TRUE
            ),
            'tran_date' => array(
                'type' => 'DATE'
            ),
            'spell' => array(
                'type' => 'VARCHAR',
                'constraint' => '50'
            ),
            'production' => array(
                'type' => 'DECIMAL',
                'constraint' => '8,3'
            ),
            'feeder_id' => array(
                'type' => 'INT',
                'constraint' => 11
            ),
            'receiver_id' => array(
                'type' => 'INT',
                'constraint' => 11
            ),
            'prod_type' => array(
                'type' => 'VARCHAR',
                'constraint' => '50'
            ),
            'mechine_id' => array(
                'type' => 'INT',
                'constraint' => 11
            ),
            'co_id' => array(
                'type' => 'INT',
                'constraint' => 11
            ),
            'updated_by' => array(
                'type' => 'INT',
                'constraint' => 11,
                'null' => TRUE
            ),
            'updated_date_time' => array(
                'type' => 'TIMESTAMP',
                'default' => 'CURRENT_TIMESTAMP',
                'on update' => 'CURRENT_TIMESTAMP'
            ),
            'is_active' => array(
                'type' => 'INT',
                'constraint' => 1,
                'default' => 1
            )
        ));
        
        $this->dbforge->add_key('sprd_lapp_id', TRUE);
        $this->dbforge->create_table('EMPMILL12.spreader_lapping_entries');
    }

    public function down()
    {
        $this->dbforge->drop_table('EMPMILL12.spreader_lapping_entries');
    }
}
