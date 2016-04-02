<?php
//Выводим список авторов
include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php'; //подключаем файл соединение с базой данных

try {
    $result = $pdo->query('SELECT id, name FROM author');
}
catch (PDOException $e) {
    $error = 'Ошибка при извлечении авторов из базы данных!' . $e->getMessage();
    include 'error.html.php';
    exit();
}
foreach ($result as $row) {
    $authors[] = array('id' => $row['id'], 'name' => $row['name']);
}
include 'authors.html.php';