<?php

use yii\db\Schema;
use yii\db\Migration;

class m160211_205038_create_login_history extends Migration
{
    /*
    public function up()
    {

    }

    public function down()
    {
        echo "m160211_205038_create_login_history cannot be reverted.\n";

        return false;
    }
    */

    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
        $this->execute("
                        CREATE TABLE IF NOT EXISTS `tbl_login_history` (
                          `id` INT NOT NULL AUTO_INCREMENT,
                          `user_id` INT NOT NULL,
                          `date_time` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
                          PRIMARY KEY (`id`),
                          INDEX `fk_clndr_login_history_1_idx` (`user_id` ASC))
                        ENGINE = InnoDB CHARACTER SET UTF8;
                        ");
    }

    public function safeDown()
    {
        $this->execute("DROP TABLE IF EXISTS `tbl_login_history`;");
    }

}
