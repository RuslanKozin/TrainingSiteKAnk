<?php

/* Запрос при котором не выбран не один критерий */
if (isset($_GET['action']) and $_GET['action'] == 'search') {
    include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';

    //Базовое выражение SELECT.
    $select = 'SELECT id, joketext';
    $from = ' FROM joke';
    $where = ' WHERE TRUE';
}

$placeholders = array();
if ($_GET['author'] != '') {  // Автор выбран.
    $where .= " AND authorid = :authorid";
    $placeholders[':authorid'] = $_GET['author'];
}
if ($_GET['category'] != '') {  //Категория выбрана.
    $from .= ' INNER JOIN jokecategory ON id = jokeid';
    $where .= " AND categoryid = :categoryid";
    $placeholders[':categoryid'] = $_GET['category'];
}
if ($_GET['text'] != '') {  //Была указана какая-то искомая строка.
    $where .= " AND joketext LIKE :joketext";
    $placeholders[':joketext'] = '%' . $_GET['text'] . '%';
}
try {
    $sql = $select . $from . $where;
    $s = $pdo->prepare($sql);
    $s->execute($placeholders);
}
catch (PDOException $e) {
    $error = 'Ошибка при извлечении шуток.';
    include 'error.html.php';
    exit();
}
foreach ($s as $row) {
    $jokes[] = array('id' => $row['id'], 'text' => $row['joketext']);
}
include 'jokes.html.php';
exit();

/* ........................ Выводим форму поиска ....................... */
include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';

try {
    $result = $pdo->query('SELECT id, name FROM author');
}
catch (PDOException $e) {
    $error = 'Ошибка при извлечении записей об авторах!';
    include 'error.html.php';
    exit();
}
foreach ($result as $row) {
    $authors[] = array('id' => $row['id'], 'name' => $row['name']);
}

try {
    $result = $pdo->query('SELECT id, name FROM category');
}
catch (PDOException $e) {
    $error = 'Ошибка при извлечениии категорий из базы данных!';
    include 'error.html.php';
    exit();
}

foreach ($result as $row) {
    $categories[] = array('id' => $row['id'], 'name' => $row['name']);
}
include 'searchform.html.php';
/*........................................................................*/