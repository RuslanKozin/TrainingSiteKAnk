<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/magicquotes.inc.php';

/* ........................ Добавление категории ......................... */
if (isset($_GET['add'])) {
    $pageTitle = 'Новая категория';
    $action = 'addform';
    $name = '';
    $id = '';
    $button = 'Добавить категорию';

    include 'form.html.php';
    exit();
}
if (isset($_GET['addform'])) {
    include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';

    try {
        $sql = 'INSERT INTO category SET name = :name';
        $s = $pdo->prepare($sql);  /*Метод prepare направлляет MySQL серверу псевдопеременную находящуюся в $sql
                    для подготовки выполнения команд, после возвращает объект PDOStatement и сохраняет в $s*/
        $s->bindValue(':name', $_POST['name']);  /*С помощью метода bindValue заменяем псевдопеременную :name на $_POST['name']*/
        $s->execute();  /*Метод execute говорит серверу MySQL выполнить запрос с предоставленными ему значениями*/
    }
    catch (PDOException $e) {
        $error = 'Ошибка при добавлении категории.' . $e->getMessage();
        include 'error.html.php';
        exit();
    }
    header('Location: .');  /*отсылаем заголовок Location, чтобы объявить о перенаправлении.
                Точка . обозначает текущий документ/директорию т.е. нужно перезагрузить текущую директорию
                после добавления шутки в базу данных*/
    exit();
}
/* ........................................................................ */

/* ...................... Редактирование категории ........................ */
if (isset($_POST['action']) and $_POST['action'] == 'Редактировать') {
    include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';

    try {
        $sql = 'SELECT id, name FROM category WHERE id = :id';
        $s = $pdo->prepare($sql);
        $s->bindValue(':id', $_POST['id']);
        $s->execute();
    }
    catch (PDOException $e) {
        $error = 'Ошибка при извлечении информации о категории.' . $e->getMessage();
        include 'error.html.php';
        exit();
    }

    $row = $s->fetch();

    $pageTitle = 'Редактировать категорию';
    $action = 'editform';
    $name = $row['name'];
    $id = $row['id'];
    $button = 'Обновить категорию';

    include 'form.html.php';
    exit();
}
if (isset($_GET['editform'])) {
    include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';

    try {
        $sql = 'UPDATE category SET name = :name WHERE id = :id';
        $s = $pdo->prepare($sql);
        $s->bindValue(':id', $_POST['id']);
        $s->bindValue(':name', $_POST['name']);
        $s->execute();
    }
    catch (PDOException $e) {
        $error = 'Ошибка при обновлении категории.' . $e->getMessage();
        include 'error.html.php';
        exit();
    }
    header('Location: .');
    exit();
}
/* ........................................................................ */

/* ...................... Удаление категорий ........................ */
if (isset($_POST['action']) and $_POST['action'] == 'Удалить') {
    include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';

    //Удаляем все записи, связывающие шутки с этой категорией.
    try {
        $sql = 'DELETE FROM jokecategory WHERE categoryid = :id';
        $s = $pdo->prepare($sql);
        $s->bindValue(':id', $_POST['id']);
        $s->execute();
    }
    catch (PDOException $e) {
        $error = 'Ошибка при удалении шуток из категории.' . $e->getMessage();
        include 'error.html.php';
        exit();
    }
    //Удаляем категорию.
    try {
        $sql = 'DELETE FROM category WHERE id = :id';
        $s = $pdo->prepare($sql);
        $s->bindValue(':id', $_POST['id']);
        $s->execute();
    }
    catch (PDOException $e) {
        $error = 'Ошибка при удалении категории.' . $e->getMessage();
        include 'error.html.php';
        exit();
    }
    header('Location: .');
    exit();
}
/* ............................................................................. */

/* ....................... Выводим список категорий ...................... */
include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';

try {
    $result = $pdo->query('SELECT id, name FROM category');
}
catch (PDOException $e) {
    $error = 'Ошибка при извлечении категорий из базы данных!' . $e->getMessage();
    include 'error.html.php';
    exit();
}

foreach ($result as $row) {
    $categories[] = array('id' => $row['id'], 'name' => $row['name']);
}
include 'categories.html.php';