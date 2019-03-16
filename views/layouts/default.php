<!DOCTYPE html>
<html>
<head>
    <title></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<body>

<header>

</header>

<div>
    <form action="<?php $_SERVER["REQUEST_URI"] ?>" method="post" enctype="multipart/form-data">
        <input name="userFile[]" type="file" multiple>
        <input type=submit name="download" value=Загрузить>
    </form>
</div>
<div>
    <table border="0" bgcolor="silver">
        <tr align=left>
            <td valign="top">

                <br>
                <table>
                    <tr align=left>
                        <td valign="top">
                            В папке сейчас:
                        </td>
                    </tr>
                    <tr align=left>
                        <td valign="top">
                            <form action="<?= $_SERVER["REQUEST_URI"] ?>" method="post">
                                <?php foreach ($dirContents as $dirContent): ?>
                                    <input type="checkbox" name="<?php echo 'option[' . $dirContent['name'] . ']'; ?>"
                                           value="<?php echo $dirContent['dir'] . $dirContent['file']; ?>">
                                    <?php echo $dirContent['file']; ?>
                                    <br>
                                <?php endforeach; ?>
                                <br>
                                <input type="submit" value="Обработать" name="button_process_files">
                                <input type="submit" name="button_delete_files" id="button_delete_files"
                                       value="Удалить">
                            </form>
                        </td>
                    </tr>
                </table>

            </td>
            <td>
                <br>
                <table>
                    <tr align=left>
                        <td valign="top">
                            В базе сейчас:
                        </td>
                    </tr>
                    <tr align=left>
                        <td valign="top">
                            <form action="<?= $_SERVER["REQUEST_URI"] ?>" method="post">
                                <?php if ($dbContents): ?>
                                    <?php foreach ($dbContents as $dbContent): ?>
                                        <input type="checkbox" name="<?php echo 'opt[]'; ?>"
                                               value="<?php echo $dbContent['value']; ?>">
                                        <?php echo $dbContent['week'] . '   ' . $dbContent['kolvo'] . '   ' . $dbContent['date'] . '   ' . $dbContent['time']; ?>
                                        <br>
                                    <?php endforeach; ?>
                                    <br>
                                    <input type="submit" name="button_delete_data_db" id="button_delete_data_db"
                                           value="Удалить">
                                <?php else: ?>
                                    Ничего нет
                                <?php endif; ?>
                            </form>
                        </td>
                    </tr>
                </table>

            </td>
        </tr>
        <tr>
            <td colspan="2">
                Для бланков:
                <form action="<?= $_SERVER["REQUEST_URI"] ?>" method="post">
                    <input type="submit" value="Создать данные для бланков" name="button_create_data_blank">
                    <input type="submit" value="Создать ексель" name="submit_create_excel">
                    <?php if (file_exists('Universal.xlsx')): ?>
                        <input type="submit" value="Удалить" name="button_delete_excel">
                        <input type="button" value="Скачать Shopid" onClick='location.href = "Shopid.xlsx"'>
                        <input type="button" value="Скачать Universal" onClick='location.href = "Universal.xlsx"'>
                    <?php else: ?>
                        <input type="submit" value="Удалить" name="button_delete_excel" disabled=disabled>
                        <input type="button" value="Скачать Shopid" disabled=disabled>
                        <input type="button" value="Скачать Universal" disabled=disabled>
                    <?php endif; ?>
                </form>
            </td>
        </tr>
    </table>
</div>

<?php

echo $content;

?>

</body>
</html>