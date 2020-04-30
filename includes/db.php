<?php

namespace Includes;

/**
 * Class Sitemap
 */
class DB
{
    protected $settings = [

    ];

    function __construct($host, $user, $pass, $db = '', $port = 3306)
    {
        $this->settings['host'] = $host;
        $this->settings['user'] = $user;
        $this->settings['pass'] = $pass;
        $this->settings['port'] = $port;
        $this->settings['connection'] = new \PDO('mysql:host='.$host.';dbname='.$db, $user, $pass);

        return $this;
    }

    public function сreateTableConstruct($table, $fields)
    {
        global $fsdbh;

        $sql = "CREATE TABLE IF NOT EXISTS `$table` (";
        $pk  = '';

        foreach($fields as $field => $type)
        {
            $sql.= "`$field` $type,";

            if (preg_match('/AUTO_INCREMENT/i', $type))
            {
                $pk = $field;
            }
        }

        $sql = rtrim($sql,',') . ' PRIMARY KEY (`'.$pk.'`)';

        $sql .= ") CHARACTER SET utf8 COLLATE utf8_general_ci"; return $sql;
        if($fsdbh->exec($sql) !== false) { return 1; }
    }

    public function сreateTable($table, $fields)
    {
        return $this->settings['connection']->exec($this->сreateTableConstruct($table, $fields));
    }

    public function registerUser(array $fields)
    {
        $data = [];
        $query = '';

        foreach ($fields as $k => $field) {
            $data[$k] = $field['value'];
            $query .= '`'.$k.'` = :'.$k.', ';
        }

        $query = substr($query, 0, -2);

        if ($data) {
            $sth = $this->settings['connection']->prepare("INSERT INTO `orders` SET " . $query);
            $sth->execute($data);
            $insert_id = $this->settings['connection']->lastInsertId();
            print_r($insert_id);
        }
    }
}

/*

CREATE TABLE `bureau`.`orders` (
`id` INT NOT NULL,
`first-name` VARCHAR(255) NULL,
`last-name` VARCHAR(255) NULL,
`old-last-name` VARCHAR(255) NULL,
`patronymic` VARCHAR(255) NULL,
`last-name_lat` VARCHAR(255) NULL,
`first-name_lat` VARCHAR(255) NULL,
`gender` VARCHAR(255) NULL,
`birthdate` VARCHAR(255) NULL,
`marital-status` VARCHAR(255) NULL,
`education` VARCHAR(255) NULL,
`phone` VARCHAR(255) NULL,
`email` VARCHAR(255) NULL,
PRIMARY KEY (`id`));

 */

