<?php
$srcurl = 'http://trainingsitekank/recentjokes(Chapter12)/controller.php';
$tempfilename = $_SERVER['DOCUMENT_ROOT'] .
    '/recentjokes(Chapter12)/tempindex.html';
$targetfilename = $_SERVER['DOCUMENT_ROOT'] .
    '/recentjokes(Chapter12)/index.html';

if (file_exists($tempfilename)) {   //file_exists - проверяет, существует ли файл с заданным именем.
    unlink($tempfilename);          //unlink - удаляет файл
}

/* ............................... Загрузка динамической страницы .......................... */
$html = file_get_contents($srcurl);   /*file_get_contents - Открывает файл, считывает содержимое и возвращает
                                      его в виде строки. Файл хранится на жестком диске сервера или, как
                                      в случае с браузером, загружается по URL*/
if (!$html) {
    $error = "Не удалось загрузить $srcurl. Обновление статической страницы прервано!";
    include $_SERVER['DOCUMENT_ROOT'] . '/includes/error.html.php';
    exit();
}
/* .......................................................................................... */

/* .............................. Запись содержимого страницы ............................... */
if (!file_put_contents($tempfilename, $html)) {
    $error = "Не удалось произвести запись в $tempfilename. Обновление статической страницы прервано!";
    include $_SERVER['DOCUMENT_ROOT'] . '/includes/error.html.php';
    exit();
}
/*............................................................................................*/

/* ................................. Копирование с заменой .................................. */
copy($tempfilename, $targetfilename);   /*copy - копировать(В данном случае, копируем, чтобы заменить)*/
unlink($tempfilename);      /*unlink - Удаляем файл*/
/*............................................................................................*/