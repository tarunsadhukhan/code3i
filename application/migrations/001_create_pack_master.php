<?php

class Migration_Create_pack_master extends CI_Migration {

    public function up() {
        $this->dbforge->add_field(array(
            'pack_id' => array(
                'type' => 'BIGINT',
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'packcode' => array(
                'type' => 'SMALLINT',
                'null' => TRUE
            ),
            'packing' => array(
                'type' => 'CHAR',
                'constraint' => 10,
                'null' => TRUE
            ),
            'calc' => array(
                'type' => 'CHAR',
                'constraint' => 1,
                'null' => TRUE
            ),
            'shr_pack' => array(
                'type' => 'CHAR',
                'constraint' => 5,
                'null' => TRUE
            ),
            'user_id' => array(
                'type' => 'INT',
                'null' => TRUE
            ),
            'ent_date_time' => array(
                'type' => 'DATETIME',
                'null' => FALSE,
                'default' => 'CURRENT_TIMESTAMP'
            )
        ));

        $this->dbforge->add_key('pack_id', TRUE);
        $this->dbforge->add_key('packcode');
        $this->dbforge->add_key('packing');

        $this->dbforge->create_table('pack_master', TRUE);
    }

    public function down() {
        $this->dbforge->drop_table('pack_master', TRUE);
    }
}
