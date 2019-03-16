<?php

namespace files;

use lib\DB;
use PclZip;

abstract class File
{
    public $table;
    public $columns;
    public $error = false;

    abstract public function saveToDB($line);
    abstract public function deleteFromDB($file);
    abstract public function getDataIndexTable();

    public static function initFile($file)
    {
        $params = [
            'Products' => 'files\Products',
            'Full' => 'files\Fullprice',
            'Shops' => 'files\Shops'
        ];

        foreach ($params as $param => $class) {
            $string = strripos($file, $param);
            if ($string) {
                return new $class;
            }
        }

        return false;
    }

    public function processExcel($file)
    {
        $archive = new PclZip($file);
        if ($archive->extract() == 0) {
            die("Error : " . $archive->errorInfo(true));
        }

        $file = file_get_contents('xl/sharedStrings.xml');
        $xml = (array)simplexml_load_string($file);
        $sst = [];
        foreach ($xml['si'] as $item => $val) {
            $sst[] = (string)$val->t;
        }

        $file = file_get_contents('xl/worksheets/sheet1.xml');
        $xml = simplexml_load_string($file);
        //$xml = simplexml_load_file('xl/worksheets/sheet1.xml');

        $data = [];
        foreach ($xml->sheetData->row as $row) {
            $currow = [];
            foreach ($row->c as $c) {
                $value = (string)$c->v;

                $attrs = $c->attributes();
                $value1 = $attrs['r'];
                $value1 = str_replace(["1", "2", "3", "4", "5", "6", "7", "8", "9", "0"], "", $value1);
                if ($attrs['t'] == 's') {
                    $currow[$value1] = $sst[$value];
                } else {
                    $currow[$value1] = $value;
                }
            }
            $data[] = $currow;
        }

        return $data;
    }

    public function getColumns()
    {
        return $this->columns;
    }

    protected function addRowsToDB($number, $set)
    {
        if ($number == 25 || ($number == 'finish' && $set != '')) {
            $set = substr($set, 0, -2);

            $query = "INSERT INTO " . $this->table . " (" . DB::convertColumnsToRow($this->columns) . ") VALUES " . $set;

            $result = DB::add($query);

            if ($result == 0) {
                $this->error = 'Ошибка вставки данных в БД';
                return false;
            }

            return true;
        }

        return false;
    }
}