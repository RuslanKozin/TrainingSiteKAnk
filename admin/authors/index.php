<?php
/* ..................... Удаление автора ......................... */
if(isset($_POST['action']) and $_POST['action'] == 'Удалить') {  /*Если существует переменная $_POST['action'] -
        глобальный массив $_POST со значением action, and и значение переменной $_POST равно Удалить
    выполнить код ниже..*/
    include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';  /*Связываемся с базой данных*/

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
    /*Необходимо получить список всех шуток конкретного автора по запросу SELECT и, пока идет перебор этого списка,
    выполннить для каждого элемента команду DELETE. Проблема в том, что нельзя приостановить работу сервера MySQL
    на полпути и попросить переключиться на команды DELETE, в то время как он возвращает результаты выполнения
    запроса SELECT.
        Это приведет к тому, что запросы на удаление завершатся ошибками.*/

            //Здесь нам и пригодится метод fetchAll.
    $result = $s->fetchAll();  /*Метод fetchAll - вызванный из заранее подготовленного выражения $s.
            Метод fetchAll извлекает из запроса весь набор результатов и помещает его в массив $result*/

    /*Теперь можно пройтись по массиву с помощью цикла foreach и извлечь каждую строку по очереди.*/

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