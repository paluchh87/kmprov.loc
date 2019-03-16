<?php

namespace models;

use lib\DB;
use components\Model;

class Main extends Model
{
    public function createDataReports()
    {
        $this->createData();

        return $this->message;
    }

    protected function createData()
    {
        $query = "SELECT DISTINCT `week` FROM `fullprice` ORDER BY `week`";
        $weeks = DB::getColumn($query);

        DB::truncateTable('fullprice_shops');

        $query = "INSERT INTO fullprice_shops (`week`, `shopid`, `status`) SELECT `week`, `shopid`, 'ok' FROM `fullprice` GROUP BY `week`, `shopid`";
        $result = DB::add($query);

        if ($result == 0) {
            $this->message['error'][] = 'Данные не сгенерированы';

            return false;
        }

        $this->dataLastTwoWeeks($weeks);

        DB::truncateTable('fullprice_new');
        $query = "INSERT INTO fullprice_new (`shopid`, `productid`) SELECT `shopid`,`productid` FROM `fullprice` WHERE `status`!='DELETE' GROUP BY `shopid`,`productid`";
        $result = DB::add($query);
        if ($result == 0) {
            $this->message['error'][] = 'Данные не сгенерированы';

            return false;
        } else {
            $this->message['message'][] = 'Данные сгенерированы';

            return true;
        }
    }

    protected function dataLastTwoWeeks($weeks)
    {
        for ($r = 0; $r < 2; $r++) {
            $query = "SELECT COUNT(*), `shopid` FROM fullprice_shops GROUP BY `shopid`";
            $results = DB::getAll($query);

            $shops = '';
            foreach ($results as $result) {
                if ($result['COUNT(*)'] > 2) {
                    $shops .= $result['shopid'] . ', ';
                }
            }
            $shops = substr($shops, 0, -2);

            if ($shops !== '') {
                $params = [
                    'week' => $weeks[$r],
                ];

                $query = "DELETE FROM fullprice_shops WHERE `shopid` IN (" . $shops . ") AND `week`=:week";
                DB::set($query, $params);

                $query = "UPDATE `fullprice` SET `status`='DELETE' WHERE `shopid` IN (" . $shops . ") AND `week`=:week";
                DB::set($query, $params);
            }
        }

        return true;
    }
}
