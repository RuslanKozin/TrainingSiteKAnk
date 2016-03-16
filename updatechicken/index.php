<?php
try{
    $sql = 'UPDATE joke SET jokedate="2012-04-01" WHERE joketext LIKE "%цыпленок%"';
    $affectedRows = $pdo->exec($sql);
}
catch(PDOException $e){
    $output = 'Ошибка при выполнении обновления: ' . $e->getMessage();
    include 'output.html.php';
    exit();
}
$output = "Обновлено столбцов: $affectedRows";
include 'output.html.php';