<?php

namespace reports;

use lib\DB;

class Shopid extends Report
{
    public function __construct()
    {
        $this->columns = [
            'shopid',
            'productid',
            'Region',
            'City',
            'Customer',
            'Shop',
            'Address',
            'Group',
            'Brand',
            'Product'
        ];
        $this->table = 'fullprice_report_shopid';
        $this->header = [
            'Shopid',
            'ID Product',
            'Region',
            'City',
            'Customer',
            'Shop',
            'Address',
            'Group',
            'Brand',
            'Product'
        ];
        $this->file = 'Shopid';
    }

    protected function getQuery()
    {
        $query = "SELECT " . DB::convertColumnsToRow($this->columns) . " FROM `" . $this->table . "`";

        return $query;
    }

    public function generateData()
    {
        DB::truncateTable($this->table);

        $query = "INSERT INTO " . $this->table . " (`shopid`, `productid`, `Product`, `Brand`, `Group`, `Deleted`, `Shop`, `City`, `Address`,`Region`,`Customer`,`Info`) SELECT fullprice_new.shopid, fullprice_new.productid, products.Product, products.Brand, products.Group, products.Deleted, shops.Shop, shops.City, shops.Address, shops.Region,shops.Customer,shops.Info FROM fullprice_new LEFT JOIN shops ON (shops.shopid=fullprice_new.shopid) LEFT JOIN products ON products.productid = fullprice_new.productid";
        DB::add($query);

        $query = "DELETE FROM " . $this->table . " WHERE `Deleted`='Deleted' OR `Info`='close'";
        DB::set($query);

        return true;
    }
}