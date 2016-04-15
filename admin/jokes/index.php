<?php
/*................................... Поиск шуток .......................................*/
/* Запрос при котором не выбран не один критерий */
if (isset($_GET['action']) and $_GET['action'] == 'search') {
    include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';

    //Базовое выражение SELECT.
    $select = 'SELECT id, joketext';
    $from = ' FROM joke';
    $where = ' WHERE TRUE';  /*WHERE TRUE - где истина*/
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
    $where .= " AND joketext LIKE :joketext";    /*Ключ. слово LIKE сообщает MySQL, что указанный столбец должен
                удовлетворять заданному шаблону. В нашем случае это ('%' . $_GET['text'] . '%')*/
    $placeholders[':joketext'] = '%' . $_GET['text'] . '%';
}
try {  /*Формируем все составляющие SQL-запроса*/
    $sql = $select . $from . $where;  /*В переменной $sql получется следующий SQL-запрос:
    $sql = 'SELECT id, joketext  ($select)
            FROM joke INNER JOIN jokecategory ON id = jokeid   ($from)
            WHERE TRUE AND authorid = :authorid AND categoryid = :categoryid AND joketext LIKE :joketext'   ($where)*/
    $s = $pdo->prepare($sql);   /*Метод prepare направлляет MySQL серверу псевдопеременную находящуюся в $sql
                    для подготовки выполнения команд, после возвращает объект PDOStatement и сохраняет в $s*/
    $s->execute($placeholders);  /*Поскольку массив $placeholders хранит значения всех псевдопеременных, можно
                        передать их в метод execute сразу, а не указывать с помощью bindValue каждое в отдельности.*/
                    /*Метод execute говорит серверу MySQL выполнить запрос с предоставленными ему значениями*/
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
/*.....................................................................................*/

/* ............................... Выводим форму поиска .............................. */
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
/*.....................................................................................*/