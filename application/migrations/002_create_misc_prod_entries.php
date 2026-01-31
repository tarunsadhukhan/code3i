<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_misc_prod_entries extends CI_Migration {

    public function up()
    {
        $this->dbforge->add_field(array(
            'misc_prod_ent_id' => array(
                'type' => 'INT',
                'auto_increment' => TRUE,
            ),
            'tran_date' => array(
                'type' => 'DATE',
            ),
            'sliver_wastage' => array(
                'type' => 'DECIMAL',
                'constraint' => '8,3',
            ),
            'hess_wastage' => array(
                'type' => 'DECIMAL',
                'constraint' => '8,3',
            ),
            'sacking_wastage' => array(
                'type' => 'DECIMAL',
                'constraint' => '8,3',
            ),
            'beaming_wastage' => array(
                'type' => 'DECIMAL',
                'constraint' => '8,3',
            ),
            'winding_wastage' => array(
                'type' => 'DECIMAL',
                'constraint' => '8,3',
            ),
            'finishing_wastage' => array(
                'type' => 'DECIMAL',
                'constraint' => '8,3',
            ),
            'roll_weight_wastage' => array(
                'type' => 'DECIMAL',
                'constraint' => '8,3',
            ),
            'hands_mt_roll' => array(
                'type' => 'DECIMAL',
                'constraint' => '8,3',
            ),
            'sale_yarn' => array(
                'type' => 'DECIMAL',
                'constraint' => '8,3',
            ),
            'purchase_yarn' => array(
                'type' => 'DECIMAL',
                'constraint' => '8,3',
            ),
            'yarn_purchase_hands' => array(
                'type' => 'DECIMAL',
                'constraint' => '8,3',
            ),
            'jbo_consumption' => array(
                'type' => 'DECIMAL',
                'constraint' => '8,3',
            ),
            'jbo_rate' => array(
                'type' => 'DECIMAL',
                'constraint' => '8,3',
            ),
            'c_acid' => array(
                'type' => 'DECIMAL',
                'constraint' => '8,3',
            ),
            'c_acid_rate' => array(
                'type' => 'DECIMAL',
                'constraint' => '8,3',
            ),
            'rbo_cons' => array(
                'type' => 'DECIMAL',
                'constraint' => '8,3',
            ),
            'rbo_rate' => array(
                'type' => 'DECIMAL',
                'constraint' => '8,3',
            ),
            'power_unit' => array(
                'type' => 'INT',
            ),
            'adjustment_unit' => array(
                'type' => 'INT',
            ),
            'winding_wvg_diff' => array(
                'type' => 'DECIMAL',
                'constraint' => '8,3',
            ),
            'co_id' => array(
                'type' => 'INT',
            ),
            'is_active' => array(
                'type' => 'INT',
                'default' => 1,
            ),
            'updated_by' => array(
                'type' => 'INT',
            ),
            'updated_date_time' => array(
                'type' => 'TIMESTAMP',
                'default' => 'CURRENT_TIMESTAMP',
            ),
        ));
        $this->dbforge->add_key('misc_prod_ent_id', TRUE);
        $this->dbforge->create_table('misc_prod_entries');
    }

    public function down()
    {
        $this->dbforge->drop_table('misc_prod_entries');
    }
}
