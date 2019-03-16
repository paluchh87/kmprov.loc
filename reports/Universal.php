<?php

namespace reports;

use lib\DB;

class Universal extends Report
{
    public function __construct()
    {
        $this->columns = ['shop', 'Group', 'Brand', 'Product', 'productid'];
        $this->table = 'fullprice_report_universal';
        $this->header = ['Shop', 'Group', 'Brand', 'Product', 'ID Product'];
        $this->file = 'Universal';
    }

    protected function getQuery()
    {
        $query = "SELECT " . DB::convertColumnsToRow($this->columns) . " FROM `" . $this->table . "` GROUP BY " . DB::convertColumnsToRow($this->columns) . "";

        return $query;
    }

    public function generateData()
    {
        DB::truncateTable('fullprice_shops_count');
        DB::truncateTable('fullprice_products_count');
        DB::truncateTable('fullprice_update');
        DB::truncateTable($this->table);

        $query = "INSERT INTO fullprice_update (`week`,`shopid`,`productid`,`shop`) SELECT fullprice.week, fullprice.shopid, fullprice.productid, shops.Shop FROM fullprice LEFT JOIN shops ON shops.shopid = fullprice.shopid";
        DB::add($query);

        $query = "INSERT INTO fullprice_shops_count(`week`, `count`,`shop`) SELECT `week`, COUNT(DISTINCT `shopid`),`shop` FROM fullprice_update GROUP BY `week`,`shop`";
        DB::add($query);

        $query = "INSERT INTO fullprice_products_count(`productid`,`week`,count,`shop`) SELECT `productid`,`week`,COUNT(*),`shop` FROM fullprice_update GROUP BY `productid`,`week`,`shop`";
        DB::add($query);

        $query = "INSERT INTO " . $this->table . " (`week`,`productid`, `Product`, `Brand`, `Group`, `Deleted`,`count_sh`,`count_pr`,`rr`,`shop`) SELECT fullprice_products_count.week, fullprice_products_count.productid, products.Product, products.Brand, products.Group, products.Deleted, fullprice_shops_count.count,fullprice_products_count.count,fullprice_products_count.count/fullprice_shops_count.count, fullprice_products_count.shop FROM fullprice_products_count LEFT JOIN fullprice_shops_count ON (fullprice_shops_count.week=fullprice_products_count.week AND fullprice_shops_count.shop=fullprice_products_count.shop) LEFT JOIN products ON products.productid = fullprice_products_count.productid";
        DB::add($query);

        $query = "DELETE FROM " . $this->table . " WHERE `Deleted`='Deleted' OR `rr`<=0.05";
        DB::set($query);

        return true;
    }
}