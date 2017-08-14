<?php
/**
 * Created by PhpStorm.
 * User: yusuf
 * Date: 07.08.2017
 * Time: 15:35
 */

namespace src\adapter;

use PDO;

/**
 * Class Adapter
 * @package src\adapter
 */
abstract class Adapter
{

    const mysqlUser = "root";
    const mysqlPass = "123456789";
    const mysqlHost = "localhost";
    const mysqlDatabase = "Project";

    /**
     * @var string
     */
    protected $query = null;

    /**
     * @var object
     */
    protected $connection = null;

    /**
     * @var array|null|string
     */
    protected $result = null;

    public function __construct()
    {
        $pdo = new PDO("mysql:host=" . Adapter::mysqlHost . ";dbname=" . Adapter::mysqlDatabase,
            Adapter::mysqlUser, Adapter::mysqlPass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $pdo->exec("set names utf8");
        $this->connection = $pdo;

    }

    /**
     * Veritabanına ekleme yapacak genel metod.
     * @param $entity object
     */
    public function insert($entity)
    {
        $className = explode("entity\\", get_class($entity));
        $className = $className[1];
        $keyQuery = "";
        $valueQuery = "";
        $entityMethods = get_class_methods($entity);
        foreach ($entityMethods as $field) {
            if (substr($field, 0, 3) == "get") {
                $value = $entity->{$field}();
                if ($value != null) {
                    $key = lcfirst(str_replace("get", "", $field));
                    $valueQuery .= "'" . $value . "',";
                    $keyQuery .= $key . ",";
                }
            }
        }
        $valueQuery = substr($valueQuery, 0, -1);
        $keyQuery = substr($keyQuery, 0, -1);


        $this->query = "INSERT INTO " . $className . "(" . $keyQuery . ") VALUES(" . $valueQuery . ")";

    }

    /**
     * Veritabanında güncelleme yapmamızı sağlayacak genel medot
     * @param $entity object
     */
    public function update($entity)
    {
        $className = explode("entity\\", get_class($entity));
        $className = $className[1];

        $entityMethods = get_class_methods($entity);
        if (in_array("getId", $entityMethods)) {
            $entityId = $entity->getId();
            $updateFieldList = null;
            foreach ($entityMethods as $field) {
                if ($field != "getId") {
                    if (substr($field, 0, 3) == "get") {
                        $value = $entity->{$field}();
                        if ($value != null) {
                            $key = lcfirst(str_replace("get", "", $field));
                            $updateFieldList[] = $key . "='" . $value . "'";
                        }
                    }
                }
            }
            $updateQuery = implode(",", $updateFieldList);

            $query = "UPDATE " . $className . " SET " . $updateQuery . " WHERE id='" . $entityId . "'";
            $this->query = $query;
        }
    }


    /**
     * veritanından bilgi çekmemizi sağlayacak genel metod
     * @param $tableName string
     * @param $params array
     */
    public function select($tableName, $params)
    {
        $whereQuery = "";
        $selectQuery = "SELECT * FROM " . $tableName;
        if ($params == null) {
            $this->query = $selectQuery;
        } else {
            $whereQuery = null;
            if (isset($params)) {
                foreach ($params as $key => $value) {
                    $valueType = gettype($value);
                    if ($valueType == "array") {
                        $whereQuery .= " " . $key . " ";
                        $whereList = null;
                        foreach ($value as $k => $v) {
                            $whereList[] = $k . "='" . $v . "'";
                        }
                        $whereQuery .= implode(",", $whereList);
                    } else {
                        $whereQuery .= $key . "='" . $value . "'";
                    }
                }
                $selectQuery .= " WHERE " . $whereQuery;
            }
        }
        $this->query = $selectQuery;
    }

    /**
     * Veritabından bir veri silmek için genel metod
     * @param $entity object
     * @return bool
     */
    public function delete($entity)
    {
        $entityMethods = get_class_methods($entity);
        $className = explode("entity\\", get_class($entity));
        $className = $className[1];
        if (in_array("getId", $entityMethods)) {
            $entityId = $entity->getId();
            $whereQuery = " WHERE id='" . $entityId . "'";
            $entityQuery = "DELETE FROM " . $className;
            $deleteQuery = $entityQuery . $whereQuery;
            $this->query = $deleteQuery;
            return true;
        }
        return false;
    }

    public function deleteWhereId($tableName,$where)
    {
        $queryAdd = "";
        foreach ($where as $key => $wh){
            $queryAdd .= " WHERE ".$key."='".$wh."'";
        }
        $query = "DELETE FROM ". $tableName.$queryAdd;
        $this->query = $query;
    }

    /**
     * şartı bulunmayan select() metoduna ek olarak sorguya
     * LIKE şartını dahil eden metod.
     * @param $params
     */
    public function withLike($params){
        $getKey = key($params);
        $value = $params[$getKey];
        $this->query .= " WHERE ".$getKey." LIKE '%".$value."%'";
    }

    /**
     * Şartı bulunmayan select() metoduna ek olarak sorguya
     * MATCH şartını dahil eden metod
     * @param $matchQuery
     * @param $q
     */
    public function withAgainst($matchQuery,$q){
        $this->query .= " WHERE MATCH (".$matchQuery.") AGAINST('$q')";
    }

    /**
     *  $query değişkeninde bulunan sorguyu çalıştırmaya yarayan metod
     */
    public function execute()
    {
        $this->result = $this->connection->query($this->query, PDO::FETCH_ASSOC);
    }

    /**
     * $query de bulunan sorguyu geri döndüren metod
     * @return string
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * $query elle yazılmış bir sorgu göndermek için kullanılan metod.
     * @param $query string
     */
    public function setQuery($query){
        $this->query = $query;
    }

    /**
     * veritabanı nesnesini geri döndüren metod.
     * @return object
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * execute() metodundan sonra sonuçları almak için kullanılan metod.
     * @return array
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * Tek satırlı sorguları kolayca çekmek için kullanılan metod
     */
    public function executeFetch(){
        $this->result = $this->connection->query($this->query)->fetch(PDO::FETCH_ASSOC);
    }

    public function lastId(){
        return $this->connection->lastInsertId();
    }


}