<?php
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