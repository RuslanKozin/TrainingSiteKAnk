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
        $s = $pdo->prepare($sql);
        $s->bindValue(':name', $_POST['name']);
        $s->execute();
    }
    catch (PDOException $e) {
        $error = 'Ошибка при добавлении категории.' . $e->getMessage();
        include 'error.html.php';
        exit();
    }
    header('Location: .');
    exit();
}
/* ........................................................................ */

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