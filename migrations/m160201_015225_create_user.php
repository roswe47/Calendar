<?php

use yii\db\Schema;
use yii\db\Migration;

class m160201_015225_create_user extends Migration
{
    /*
    public function up()
    {

    }

    public function down()
    {
        echo "m160201_015225_create_user cannot be reverted.\n";

        return false;
    }
    */

    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
        $this->execute("
                        CREATE TABLE IF NOT EXISTS `tbl_user` (
                          `id` INT NOT NULL AUTO_INCREMENT,
                          `username` VARCHAR(128) NOT NULL,
                          `name` VARCHAR(45) NOT NULL,
                          `surname` VARCHAR(45) NOT NULL,
                          `password` VARCHAR(255) NOT NULL,
                          `salt` VARCHAR(255) NOT NULL,
                          `access_token` VARCHAR(255) NULL DEFAULT NULL,
                          `create_date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                          PRIMARY KEY (`id`),
                          UNIQUE INDEX `username_UNIQUE` (`username` ASC),
                          UNIQUE INDEX `access_token_UNIQUE` (`access_token` ASC))
                        ENGINE = InnoDB CHARACTER SET UTF8;
                        ");
    }

    public function safeDown()
    {
        $this->execute("DROP TABLE IF EXISTS `tbl_user`;");
    }

}
