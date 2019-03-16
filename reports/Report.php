<?php
namespace reports;

use lib\DB;
use XLSXWriter;

abstract class Report
{
    public $header;
    public $columns;
    public $table;
    public $file;

    abstract protected function getQuery();
    abstract public function generateData();

    protected function setData($columns, $source = [])
    {
        $set = [];
        foreach ($columns as $field) {
            if (isset($source[$field])) {
                $set[] = $source[$field];
            } else {
                $set[] = 'None';
            }
        }

        return $set;
    }

    public function generateExcelFile()
    {
        $writer = new XLSXWriter();
        $query = $this->getQuery();

        $data[] = $this->header;
        $results = DB::getAll($query);
        foreach ($results as $result) {
            $data[] = $this->setData($this->columns, $result);
        }

        $writer->setAuthor('Some Author');
        $writer->writeSheet($data, 'Sheet1');
        $writer->writeToFile($this->file . '.xlsx');

        return true;
    }
}