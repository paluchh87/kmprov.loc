<?php

namespace files;

use lib\DB;

class Fullprice extends File
{
    public function __construct()
    {
        $this->table = 'fullprice';
        $this->columns = [
            'week',
            'shopid',
            'status',
            'productid',
            'date',
            'time',
            'kolvo',
        ];
    }

    public function saveToDB($line)
    {
        $time = date("H:i:s");
        $date = date('Y-m-d');
        $count = count($line) - 1;

        $number = 0;
        $set = '';
        unset($line[0]);
        foreach ($line as $row) {
            $set .= "('" . $row['C'] . "','" . $row['A'] . "','nook','" . $row['O'] . "','" . $date . "','" . $time . "','" . $count . "'), ";
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

        $params = [
            'week' => $part[1],
            'time' => $part[2],
        ];

        $query = "DELETE FROM ".$this->table." WHERE `week`=:week AND `time`=:time";
        $result = DB::set($query, $params);

        return $result;
    }

    public function getDataIndexTable()
    {
        $data=null;
        $query = "SELECT DISTINCT `week`, `date`, `time`, `kolvo` FROM ".$this->table." ORDER BY `week`";
        $results = DB::getAll($query);
        foreach ($results as $result) {
            $data[] = [
                'value' => 'file_Fullprice_#'.$result['week'] . '#' . $result['time'],
                'week' => $result['week'],
                'kolvo' => $result['kolvo'],
                'date' => $result['date'],
                'time' => $result['time']
            ];
        }

        return $data;
    }
}