<?php
/**
 * Created by PhpStorm.
 * User: Student21
 * Date: 21.11.2017
 * Time: 19:15
 */

namespace Game;

class MySQL
{

    const DATABASE = "ih900197_php2609-vlad";

    /**
     * Ссылка на подключение к БД
     * @var null
     */
    private $db = null;

    /**
     * MySQL constructor.
     */
    public function __construct($db = null, $host = "localhost", $user = "ih900197_php2609-vlad", $pass = "ih900197_php2609-vlad")
    {
        if (!$db) {
            $db = self::DATABASE;
        }
        $this->db = new \mysqli($host, $user, $pass, $db);
        if ($this->db->connect_errno) {
            exit("Ошибка !!! " . $this->db->connect_error);
        }
        $this->db->set_charset("utf8");
    }

    /**
     * Запрос SELECT к БД
     * @param string        $table      имя таблицы
     * @param string        $fields     выбираемые поля
     * @param string|null   $leftJoin   присоединение других табли
     * @param string|null   $where      условие выборки
     * @param string|null   $sort       сортировка
     * @param string|null   $limit      лимит
     * @return array|bool
     */
    public function select($table, $fields = "*", $leftJoin = null, $where = null, $sort = null, $limit = null)
    {
        $query = "SELECT {$fields} FROM {$table}";

        if ($leftJoin) {
            $query .= "{$leftJoin}";
        }
        if ($where) {
            $query .= " WHERE {$where}";
        }
        if ($sort) {
            $query .= " ORDER BY {$sort}";
        }
        if ($limit) {
            $query .= " LIMIT {$limit}";
        }
        return $this->query($query);
        //return $query."<br>";
    }

    /**
     * Запрос DELETE к БД
     * @param string        $table      имя таблицы
     * @param string|null   $where      условие выборки
     * @param string|null   $sort       сортировка
     * @param string|null   $limit      лимит
     * @return array|bool
     */
    public function delete($table, $where = null, $sort = null, $limit = null)
    {
        $query = "DELETE FROM {$table}";
        if ($where) {
            $query .= " WHERE {$where}";
        }
        if ($sort) {
            $query .= " ORDER BY {$sort}";
        }
        if ($limit) {
            $query .= " LIMIT {$limit}";
        }
        return $this->query($query);
    }

    /**
     * Запрос TRUNCATE к БД
     * @param string        $table      имя таблицы
     * @param string|null   $where      условие выборки
     * @param string|null   $sort       сортировка
     * @param string|null   $limit      лимит
     * @return array|bool
     */
    public function truncate($table, $where = null, $sort = null, $limit = null)
    {
        $query = "TRUNCATE TABLE {$table}";
        if ($where) {
            $query .= " WHERE {$where}";
        }
        if ($sort) {
            $query .= " ORDER BY {$sort}";
        }
        if ($limit) {
            $query .= " LIMIT {$limit}";
        }
        return $this->query($query);
    }

    /**
     * Запрос UPDATE к БД
     * @param string        $table      имя таблицы
     * @param array         $fields     изменяемые поля
     * @param string|null   $where      условие выборки
     * @param string|null   $sort       сортировка
     * @param string|null   $limit      лимит
     * @return array|bool
     */
    public function update($table, $fields, $where = null, $sort = null, $limit = null)
    {
        $query = "UPDATE {$table} SET {$this->arrToStr($fields)}";
        if ($where) {
            $query .= " WHERE {$where}";
        }
        if ($sort) {
            $query .= " ORDER BY {$sort}";
        }
        if ($limit) {
            $query .= " LIMIT {$limit}";
        }
        return $this->query($query);
        //return $query."<br>";
    }

    /**
     * Запрос INSERT к БД
     * @param string        $table      имя таблицы
     * @param array        $into      изменяемые поля
     * @param array         $fields     вставляемые поля
     * @return array|bool
     */
    public function insert($table, $values)
    {
        foreach($values as $key => $arr){
            $orders = [];
            foreach ($arr as $name => $val) {
                $values[$key] = "(" . $this->insertArrToStr($arr) . ")";
                $orders[] = $name;
            }
        }

        $query = "INSERT INTO {$table} (".$this->insertArrToStr($orders).") VALUES ".$this->insertArrToStr($values);

        return $this->query($query);
        //return $query."<br>";
    }

    /**
     * Делает запрос к БД
     * @param string    $query  Запрос SQL
     * @return array|bool
     */
    private function query($query)
    {
        $res = $this->db->query($query);
        if ($res === false) {
            return false;
        } elseif ($res === true) {
            return true;
        } else {
            $result = array();
            while ($row = $res->fetch_assoc()) {
                $result[] = $row;
            }
            return $result;
        }
    }

    /**
     * Преобразование массива в строку
     * @param array $arr    массив полей
     * @return string
     */
    private function arrToStr($arr)
    {
        $result = array();
        foreach ($arr as $k => $v) {
            $result[] = "`{$k}` = " . (($v === null) ? "NULL" : "'{$v}'");
        }
        return implode(", ", $result);
    }

    /**
     * Преобразование массива в строку для insert
     * @param array $arr    массив полей
     * @return string
     */
    private function insertArrToStr($arr)
    {
        $result = array();
        foreach ($arr as $k => $v) {
            $result[] = (($v === null) ? "NULL" : "{$v}");
        }

        return implode(", ", $result);
    }

    /**
     * Преобразование массива в строку для from из insert
     * @param array $arr    массив полей
     * @return string
     */
    public function fromArrToStr($select)
    {
        $result = [];
        foreach ($select as $nickTable => $arr){
            foreach ($arr as $cells => $nickCells){
                $result[] = $nickTable.".".$cells." AS ".$nickCells;
            }
        }
        return implode(", ",$result);
    }

    /**
     * Преобразование массива в строку для join из insert
     * @param array $arr    массив полей
     * @return string
     */
    public function joinArrToStr($join)
    {
        $text = "";
        foreach ($join as $cells => $arr){
            foreach ($arr as $nickCells => $work){
                $text .= " LEFT JOIN ".$cells." AS ".$nickCells." ON ".$work;
            }
        }
        return $text;
    }

}