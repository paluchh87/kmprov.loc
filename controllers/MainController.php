<?php

namespace controllers;

use components\Controller;
use reports\Shopid;
use reports\Universal;

class MainController extends Controller
{
    public function actionIndex()
    {
        $dir = './excel/';

        if (!empty($_POST)) {
            $message = $this->pressedButton($dir);
        }

        $vars = [
            'dbContents' => $this->files->getDataTable(),
            'dirContents' => $this->files->getDirectoryContent($dir),
            'messages' => isset($message) ? $message : null
        ];

        $this->view->render($vars);
    }

    protected function pressedButton($dir)
    {
        if (isset($_POST['download'])) {
            return $this->files->downloadFiles($_FILES, $dir);
        }

        if (isset($_POST['button_delete_files'])) {
            return $this->files->deleteFiles($_POST['option']);
        }

        if (isset($_POST['button_delete_excel'])) {
            return $this->files->deleteFiles(['Shopid.xlsx', 'Universal.xlsx']);
        }

        if (isset($_POST['button_process_files'])) {
            return $this->files->saveFilesToDB($_POST['option']);
        }

        if (isset($_POST['submit_create_excel'])) {
            return $this->files->createExcelFiles([new Shopid(), new Universal]);
        }

        if (isset($_POST['button_delete_data_db'])) {
            return $this->files->deleteFromDB($_POST['opt']);
        }

        if (isset($_POST['button_create_data_blank'])) {
            return $this->model->createDataReports();
        }

        return false;
    }
}