<?php

namespace files;

use lib\DB;

class Products extends File
{
    public function __construct()
    {
        $this->table = 'products';
        $this->columns = [
            'productid',
            'Product',
            'Brand',
            'Group',
            'Series',
            'Deleted',
            'date',
            'time',
            'kolvo',
        ];
    }

    public function saveToDB($line)
    {
        DB::truncateTable($this->table);
        $time = date("H:i:s");
        $date = date('Y-m-d');
        $count = count($line) - 1;

        $number = 0;
        $set = '';
        unset($line[0]);
        foreach ($line as $row) {
            $set .= "(" . DB::quote($row['A']) . "," . DB::quote($row['B']) . "," . DB::quote($row['C']) . "," . DB::quote($row['D']) . "," . DB::quote($row['E']) . "," . DB::quote($row['O']) . ",'" . $date . "','" . $time . "','" . $count . "'), ";
            $number++;
            if ($this->addRowsToDB($number, $set)) {
                $number = 0;
                $set = '';
            }
        }
        $this->addRowsToDB('finish', $set);

        return $this->error;
    }

    public function deleteFromDB($file)
    {
        $part = explode("#", $file);

        $params = ['time' => $part[1]];
        $query = "DELETE FROM " .  $this->table . " WHERE `time`=:time";
        $result = DB::set($query, $params);

        return $result;
    }

    public function getDataIndexTable()
    {
        $data=null;
        $query = "SELECT `date`, `time`, COUNT(*) FROM ".$this->table." GROUP BY `date`, `time` ORDER BY `time`";
        $results = DB::getAll($query);
        foreach ($results as $result) {
            $data = [
                'value' => 'file_Products_#' . $result['time'],
                'week' => 'Products',
                'kolvo' => $result['COUNT(*)'],
                'date' => $result['date'],
                'time' => $result['time']
            ];
        }

        return $data;
    }
}