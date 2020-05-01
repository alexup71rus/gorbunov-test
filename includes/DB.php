<?php
namespace Includes;

/**
 * Class Sitemap
 */
class DB
{
    protected $pdo = null;
    private static $instance;
    private function __construct()
    {
        try
        {
            $settings = \Includes\Settings::getInstance();
            $dataSettings = $settings->db();

            if($_SERVER['HTTP_HOST'] === 'localhost') {
                $dataSettings = $settings->db()['local'];
            } else {
                $dataSettings = $settings->db()['production'];
            }

            $dsn = "mysql:dbname={$dataSettings['db']};host={$dataSettings['host']};charset=UTF8";
            $this->pdo = new \PDO($dsn, $dataSettings['login'], $dataSettings['pass']);
            $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        }
        catch (PDOException $e)
        {
            echo 'Подключение не удалось: ' . $e->getMessage();
        }
    }
    static function getInstance()
    {
        if (is_null(self::$instance))
        {
            self::$instance = new self();
        }
        return self::$instance;
    }
    public function connect()
    {
        return $this->pdo;
    }
    public function getAllUsers()
    {
        try {
            $stmt = $this->pdo->query('SELECT * FROM orders ORDER BY date DESC');
            $data = $stmt->fetchAll();

            return $data;
        } catch (\Exception $exception) {
            return $exception;
        }
    }
    public function registerUser(array $fields)
    {
        $data = [];
        $query = '';
        $arQueryKeys = [];
        $arQueryValues = [];
        $arCountValues = [];

        foreach ($fields as $k => $field) {
            $data[$k] = $field['value'];
            $arQueryKeys[] = "`".str_replace('-', '_', $k)."`";
            $arQueryValues[] = $field['value'];
            $arCountValues[] = '?';
        }

        $queryKeys = implode($arQueryKeys, ',');
        $countValues = implode($arCountValues, ',');

        if ($data) {
            try {
                $sth = $this->pdo->prepare('INSERT INTO orders (' . $queryKeys . ') VALUES (' . $countValues . ');');
                $result = $sth->execute($arQueryValues);
                $insertId = $this->pdo->lastInsertId();
                return true;
            } catch (\Exception $exception) {
                return $exception;
            }
        }
    }
    protected function __clone()
    {
    }
}
