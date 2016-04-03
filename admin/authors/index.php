<?php
/* ..................... Удаление автора ......................... */
if(isset($_POST['action']) and $_POST['action'] == 'Удалить') {
    include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';

    //Получаем шутки, принадлежащие автору.
    try {
        $sql = 'SELECT id FROM joke WHERE authorid = :id';
        $s = $pdo->prepare($sql);
        $s->bindValue(':id', $_POST['id']);
        $s->execute();
    }
    catch (PDOException $e) {
        $error = 'Ошибка при получении списка шуток, которые нужно удалить.' . $e->getMessage();
        include 'error.html.php';
        exit();
    }

    $result = $s->fetchAll();

    //Удаление записи о категориях шуток.
    try {
        $sql = 'DELETE FROM jokecategory WHERE jokeid = :id';
        $s = $pdo->prepare($sql);

        //Для каждой шутки.
        foreach ($result as $row) {
            $jokeId = $row['Id'];
            $s->bindValue(':id', $jokeId);
            $s->execute();
        }
    }
    catch (PDOException $e) {
        $error = 'Ошибка при удалении записей о категориях шутки.';
        include 'error.html.php';
        exit();
    }

    //Удалеляем шутки, принадлежащие автору.
    try {
        $sql = 'DELETE FROM joke WHERE authorid = :id';
        $s = $pdo->prepare($sql);
        $s->bindValue(':id', $_POST['id']);
        $s->execute();
    }
    catch (PDOException $e) {
        $error = 'Ошибка при удалении шуток, принадлежащих автору.';
        include 'error.html.php';
        exit();
    }

    //Удаляем имя автора.
    try {
        $sql = 'DELETE FROM author WHERE id = :id';
        $s = $pdo->prepare($sql);
        $s->bindValue(':id', $_POST['id']);
        $s->execute();
    }
    catch (PDOException $e) {
        $error = 'Ошибка при удалении автора.';
        include 'error.html.php';
        exit();
    }
    header('Location: .');
    exit();
}
/*................................................................*/

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