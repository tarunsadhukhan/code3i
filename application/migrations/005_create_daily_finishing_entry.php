<?php

class Migration_Create_daily_finishing_entry extends CI_Migration {

    public function up() {
        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'date' => array(
                'type' => 'DATE',
                'null' => TRUE
            ),
            'wvgbag' => array(
                'type' => 'INT',
                'null' => TRUE
            ),
            'cutting' => array(
                'type' => 'INT',
                'null' => TRUE
            ),
            'cutmc' => array(
                'type' => 'DECIMAL',
                'constraint' => '7,2',
                'null' => TRUE
            ),
            'hemming' => array(
                'type' => 'INT',
                'null' => TRUE
            ),
            'hemmc' => array(
                'type' => 'DECIMAL',
                'constraint' => '7,2',
                'null' => TRUE
            ),
            'sewing' => array(
                'type' => 'INT',
                'null' => TRUE
            ),
            'sewmc' => array(
                'type' => 'DECIMAL',
                'constraint' => '7,2',
                'null' => TRUE
            ),
            'herakle' => array(
                'type' => 'INT',
                'null' => TRUE
            ),
            'hermc' => array(
                'type' => 'DECIMAL',
                'constraint' => '7,2',
                'null' => TRUE
            ),
            'hsewing' => array(
                'type' => 'INT',
                'null' => TRUE
            ),
            'press' => array(
                'type' => 'INT',
                'null' => TRUE
            ),
            'premc' => array(
                'type' => 'DECIMAL',
                'constraint' => '7,2',
                'null' => TRUE
            ),
            'pckbls' => array(
                'type' => 'INT',
                'null' => TRUE
            ),
            'hsewingh' => array(
                'type' => 'DECIMAL',
                'constraint' => '5,2',
                'null' => TRUE
            ),
            'packedhs' => array(
                'type' => 'DECIMAL',
                'constraint' => '7,3',
                'null' => TRUE
            ),
            'yds' => array(
                'type' => 'INT',
                'null' => TRUE
            ),
            'packsheet' => array(
                'type' => 'DECIMAL',
                'constraint' => '7,3',
                'null' => TRUE
            ),
            'saletwin' => array(
                'type' => 'DECIMAL',
                'constraint' => '7,3',
                'null' => TRUE
            ),
            'adj_hs' => array(
                'type' => 'DECIMAL',
                'constraint' => '7,3',
                'null' => TRUE
            ),
            'adj_sk' => array(
                'type' => 'DECIMAL',
                'constraint' => '8,3',
                'null' => TRUE
            ),
            'adj_sy' => array(
                'type' => 'DECIMAL',
                'constraint' => '7,3',
                'null' => TRUE
            ),
            'adj_gc' => array(
                'type' => 'DECIMAL',
                'constraint' => '7,3',
                'null' => TRUE
            ),
            'adj_bk' => array(
                'type' => 'DECIMAL',
                'constraint' => '7,3',
                'null' => TRUE
            ),
            'packedsk' => array(
                'type' => 'DECIMAL',
                'constraint' => '7,3',
                'null' => TRUE
            ),
            'packedbk' => array(
                'type' => 'DECIMAL',
                'constraint' => '7,3',
                'null' => TRUE
            ),
            'outpkbls' => array(
                'type' => 'INT',
                'null' => TRUE
            ),
            'outpkhs' => array(
                'type' => 'DECIMAL',
                'constraint' => '7,3',
                'null' => TRUE
            ),
            'outpksk' => array(
                'type' => 'DECIMAL',
                'constraint' => '7,3',
                'null' => TRUE
            ),
            'inpkbls' => array(
                'type' => 'INT',
                'null' => TRUE
            ),
            'inpkhs' => array(
                'type' => 'DECIMAL',
                'constraint' => '7,3',
                'null' => TRUE
            ),
            'inpksk' => array(
                'type' => 'DECIMAL',
                'constraint' => '7,3',
                'null' => TRUE
            ),
            'repakbls' => array(
                'type' => 'INT',
                'null' => TRUE
            ),
            'hndcutting' => array(
                'type' => 'INT',
                'null' => TRUE
            ),
            'repakwt' => array(
                'type' => 'DECIMAL',
                'constraint' => '7,3',
                'null' => TRUE
            ),
            'user_code' => array(
                'type' => 'VARCHAR',
                'constraint' => 3,
                'null' => TRUE
            ),
            'ent_date' => array(
                'type' => 'DATE',
                'null' => TRUE
            ),
            'ent_time' => array(
                'type' => 'VARCHAR',
                'constraint' => 8,
                'null' => TRUE
            ),
            'joint_bags' => array(
                'type' => 'INT',
                'null' => TRUE
            ),
            'joint_mc' => array(
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'null' => TRUE
            ),
            'lapp_yds' => array(
                'type' => 'INT',
                'null' => TRUE
            ),
            'lapp_mc' => array(
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'null' => TRUE
            ),
            'exsewing' => array(
                'type' => 'INT',
                'null' => TRUE
            ),
            'exsewmc' => array(
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'null' => TRUE
            ),
            'press_mc_h' => array(
                'type' => 'DECIMAL',
                'constraint' => '7,2',
                'null' => TRUE
            ),
            'inpckbls_h' => array(
                'type' => 'INT',
                'null' => TRUE
            ),
            'repakbls_h' => array(
                'type' => 'INT',
                'null' => TRUE
            ),
            'bale_stk_h' => array(
                'type' => 'INT',
                'null' => TRUE
            ),
            'bale_stk_s' => array(
                'type' => 'INT',
                'null' => TRUE
            ),
            'created_at' => array(
                'type' => 'TIMESTAMP',
                'null' => FALSE,
                'default' => 'CURRENT_TIMESTAMP'
            ),
            'updated_at' => array(
                'type' => 'TIMESTAMP',
                'null' => FALSE,
                'default' => 'CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'
            )
        ));

        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->add_key('date');
        $this->dbforge->add_key('ent_date');
        $this->dbforge->create_table('tbl_daily_finishing_entry', TRUE);
    }

    public function down() {
        $this->dbforge->drop_table('tbl_daily_finishing_entry', TRUE);
    }
}
?>
