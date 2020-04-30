<?php
include __DIR__ . '/includes/settings.php';
include __DIR__ . '/includes/db.php';

$db = \Includes\DB::getInstance();
$dbConnection = $db->connect();

$table = "orders";
try {
    $dbConnection->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );//Error Handling
    $sql ="CREATE TABLE IF NOT EXISTS $table(
     `phone` VARCHAR( 255 ) NOT NULL PRIMARY KEY,
     `email` VARCHAR( 255 ) NOT NULL,
     `first_name` VARCHAR( 255 ) NOT NULL,
     `last_name` VARCHAR( 255 ) NOT NULL,
     `old_last_name` VARCHAR( 255 ) NOT NULL,
     `patronymic` VARCHAR( 255 ) NOT NULL,
     `last_name_lat` VARCHAR( 255 ) NOT NULL,
     `first_name_lat` VARCHAR( 255 ) NOT NULL,
     `gender` VARCHAR( 255 ) NOT NULL,
     `birthdate_days` VARCHAR( 255 ) NOT NULL,
     `birthdate_months` VARCHAR( 255 ) NOT NULL,
     `birthdate_years` VARCHAR( 255 ) NOT NULL,
     `marital_status` VARCHAR( 255 ) NOT NULL,
     `education` VARCHAR( 255 ) NOT NULL)
     DEFAULT CHARSET=utf8;" ;

    $dbConnection->exec($sql);

    echo 'ok';
} catch(PDOException $e) {
    var_dump($e->getMessage());
}