<?php
namespace lib;

use PDO;
use PDOException;

class DB
{
    public static $dsn = 'mysql:dbname=table;host=localhost';
    public static $user = 'user';
    public static $pass = 'password';

    public static $dbh = null;

    public static $sth = null;

    //public static $query = '';

    public static function getDbh()
    {
        if (!self::$dbh) {
            try {
                $config = require_once ROOT.'/config/db.php';

                self::$dsn = 'mysql:dbname=' . $config['name'] . ';host=' . $config['host'];
                self::$user = $config['user'];
                self::$pass = $config['password'];

                self::$dbh = new PDO(
                    self::$dsn,
                    self::$user,
                    self::$pass,
                    array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'")
                );
                self::$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
            } catch (PDOException $e) {
                exit('Error connecting to database: ' . $e->getMessage());
            }
        }

        return self::$dbh;
    }

    public static function add($query, $param = [])
    {
        self::$sth = self::getDbh()->prepare($query);
        return (self::$sth->execute((array)$param)) ? self::getDbh()->lastInsertId() : 0;
    }

    public static function set($query, $param = [])
    {
        self::$sth = self::getDbh()->prepare($query);
        return self::$sth->execute((array)$param);
    }

    public static function getRow($query, $param = [])
    {
        self::$sth = self::getDbh()->prepare($query);
        self::$sth->execute((array)$param);
        return self::$sth->fetch(PDO::FETCH_ASSOC);
    }

    public static function getAll($query, $param = [])
    {
        self::$sth = self::getDbh()->prepare($query);
        self::$sth->execute((array)$param);
        return self::$sth->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getValue($query, $param = [], $default = null)
    {
        $result = self::getRow($query, $param);
        if (!empty($result)) {
            $result = array_shift($result);
        }

        return (empty($result)) ? $default : $result;
    }

    public static function getColumn($query, $param = [])
    {
        self::$sth = self::getDbh()->prepare($query);
        self::$sth->execute((array)$param);
        return self::$sth->fetchAll(PDO::FETCH_COLUMN);
    }

    public static function truncateTable($table)
    {
        $query = "TRUNCATE TABLE `" . $table . "`";

        return self::set($query);
    }

    public static function quote($param)
    {
        return self::getDbh()->quote($param);
    }

    public static function convertColumnsToRow($columns)
    {
        $set = '';
        foreach ($columns as $column) {
            $set .= "`" . str_replace("`", "``", $column) . "`" . ", ";
        }

        return substr($set, 0, -2);
    }

    public static function lastInsertId()
    {
        return self::getDbh()->lastInsertId();
    }
}