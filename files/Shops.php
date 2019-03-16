<?php

namespace files;

use lib\DB;

class Shops extends File
{
    public function __construct()
    {
        $this->table = 'shops';
        $this->columns = [
            'shopid',
            'Shop',
            'City',
            'Address',
            'Customer',
            'Merchandiser',
            'Attribute',
            'Attribute5',
            'Latitude',
            'Longtitude',
            'Region',
            'Info',
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
            $set .= "(" . DB::quote($row['A']) . "," . DB::quote($row['B']) . "," . DB::quote($row['C']) . "," . DB::quote($row['D']) . "," . DB::quote($row['F']) . "," . DB::quote($row['H']) . "," . DB::quote($row['M']) . ",'" . $row['Q'] . "'," . DB::quote($row['S']) . "," . DB::quote($row['T']) . "," . DB::quote($row['W']) . "," . DB::quote($row['X']) . ",'" . $date . "','" . $time . "','" . $count . "'), ";
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
        $query = "SELECT `date`,`time`,COUNT(*) FROM ".$this->table."  GROUP BY `date`,`time` ORDER BY `time`";
        $results = DB::getAll($query);
        foreach ($results as $result) {
            $data = [
                'value' => 'file_Shops_#' . $result['time'],
                'week' => 'Shops',
                'kolvo' => $result['COUNT(*)'],
                'date' => $result['date'],
                'time' => $result['time']
            ];
        }

        return $data;
    }
}