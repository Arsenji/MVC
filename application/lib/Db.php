<?php
namespace application\lib;

use PDO;

class Db
{
    protected $db;

    public function __construct()
    {
       $config = require 'application/config/db.php';
       $this->db = new PDO('mysql:host='.$config['host'].';name='.$config['dbname'].'', $config['user'], $config['password']);
    }

    public function query($sql, $params = [])
    {
        $stmt = $this->db->prepare($sql);
        if(!empty($params))
        {
            foreach ($params as $key => $val)
            {
                $stmt->bindValue(':' . $key, $val);
            }

        }
        $stmt->execute();
        return $stmt;
    }

    public function row($sql, $params = []) // Возвращает список столбцов
    {
        $result = $this->query($sql, $params);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    public function column($sql, $params = []) //Возвращает столбец
    {
        $result = $this->query($sql, $params);
        return $result->fetchColumn();
    }

    public function queryFor($sql)
    {
        return $this->db->query($sql);
    }

    public function fetchAll($sql)
    {
        $result = $this->queryFor($sql);
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }

}