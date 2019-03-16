# kmprov.loc
<br><b>Задача:</b>
<br>Есть три вида excel файлов (Fullprice, Products, Shops) которые нужно добавить в БД.
<br>Иметь возможность ненужные данные удалять.
<br>Определенным образом данные в БД обработать и из них сгенерировать два отчета (Shopid, Universal) в формате XLSX.

<br>![alt text](kmprov.png) 

<br><b>Установка:</b>
<br>Импортировать в БД файл - keymarket.sql;
<br>Заполнить файл конфигурации входа в БД - \config\db.php;
<br>composer install;

<br><b>Использовались пакеты:</b>
<br><b>"pclzip/pclzip"</b> - для обработки XLSX файлов;
<br><b>"mk-j/php_xlsxwriter"</b> - для записи файлов XLSX;
