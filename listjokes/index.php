<?php
try{
    $sql = 'SELECT joketext FROM joke';
    $result = $pdo->query($sql);
}
catch(PDOException $e){
    $error = 'Ошибка при извлечении шуток: ' . $e->getMessage();
    include 'error.html.php';
    exit();
}