<?php

namespace models;

use files\File;
use files\Fullprice;
use files\Products;
use files\Shops;
use reports\Report;

class Files
{
    public $message;

    public function downloadFiles($files, $dir)
    {
        $k = sizeof($files['userFile']['name']);
        for ($i = 0; $i < $k; $i++) {
            $uploadFile = $dir . basename($files['userFile']['name'][$i]);
            if (copy($files['userFile']['tmp_name'][$i], $uploadFile)) {
                $this->message['message'][] = 'Файл ' . $files['userFile']['name'][$i] . ' успешно загружен на сервер';
            } else {
                $this->message['error'][] = 'Ошибка! Не удалось загрузить файл ' . $files['userFile']['name'][$i] . ' на сервер!';
            }
        }

        return $this->message;
    }

    public function deleteFiles($files)
    {
        foreach ($files as $file) {
            if (file_exists($file) && unlink($file)) {
                $this->message['message'][] = 'Файл ' . $file . ' удален';
            } else {
                $this->message['error'][] = 'Файла ' . $file . ' не существует';
            }

        }

        return $this->message;
    }

    public function getDirectoryContent($dir)
    {
        $i = 0;
        $dirContent = [];
        if (is_dir($dir)) {
            if ($handle = opendir($dir)) {
                while (($file = readdir($handle)) !== false) {
                    if ($file != "." && $file != "..") {
                        $dirContent[] = array(
                            'name' => $i,
                            'dir' => $dir,
                            'file' => $file,
                        );
                        $i++;
                    }
                }
                closedir($handle);
            }
        }

        return $dirContent;
    }

    private function removeDirectory($dir)
    {
        if ($objs = glob($dir . "/*")) {
            foreach ($objs as $obj) {
                is_dir($obj) ? $this->removeDirectory($obj) : unlink($obj);
            }
        }
        rmdir($dir);
    }

    public function saveFilesToDB($files)
    {
        foreach ($files as $file) {
            $class = File::initFile($file);
            if (!$class) {
                $this->message['error'][]='Файл ' . $file . ': ' .'Переименуйте/Выбирите файл: Products, Fullprice или Shops';
                break;
            }

            $line = $class->processExcel($file);
            if ($message = $class->saveToDB($line)) {
                $this->message['error'][] = 'Файл ' . $file . ': ' . $message;
            } else {
                $this->message['message'][] = 'Файл ' . $file . ' обработан';
            }

            unset($line);
            $this->removeDirectory('xl');
            $this->removeDirectory('docProps');
            unlink("[Content_Types].xml");
            unlink('./_rels/.rels');
            $this->removeDirectory('_rels');
        }

        return $this->message;
    }

    public function createExcelFiles($files)
    {
        if (!is_array($files)) {
            $files = compact('files');
        }

        foreach ($files as $file) {
            if ($this->createDataToReport($file)) {
                $this->createExcelFile($file);
            }
        }

        return $this->message;
    }

    protected function createDataToReport(Report $file)
    {
        if ($file->generateData()) {
            $this->message['message'][] = 'Данные для ' . $file->file . ' созданы';

            return true;
        } else {
            $this->message['error'][] = 'Данные для ' . $file->file . ' не созданы';

            return false;
        }
    }

    protected function createExcelFile(Report $file)
    {
        if (file_exists($file->file . '.xlsx')) {
            $this->message['error'][] = 'Удалите файл ' . $file->file;

            return false;
        } else {
            if ($file->generateExcelFile()) {
                $this->message['message'][] = 'Файл ' . $file->file . ' создан';

                return true;
            } else {
                $this->message['error'][] = 'Файл ' . $file->file . ' не создан';

                return false;
            }
        }
    }

    public function deleteFromDB($options)
    {
        foreach ($options as $opt) {
            $class = File::initFile($opt);
            $result = $class->deleteFromDB($opt);

            if ($result === true) {
                $this->message['message'][] = 'Данные удалены';
            } else {
                $this->message['error'][] = 'Ошибка удаления данных';
            }
        }

        return $this->message;
    }

    public function getDataTable()
    {
        $fullprice = new Fullprice();
        if (!$data = $fullprice->getDataIndexTable()) {
            $data = [];
        }

        $products = new Products();
        if ($prod = $products->getDataIndexTable()) {
            array_push($data, $prod);
        }

        $shops = new Shops();
        if ($shop = $shops->getDataIndexTable()) {
            array_push($data, $shop);
        }

        return $data;
    }
}