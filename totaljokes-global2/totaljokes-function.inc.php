<?php
include_once  $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';
function totalJokes() {
    try {
        $result  =  $GLOBALS['pdo']->query(' SELECT COUNT(*)  FROM joke');
    }

    /*Специальный массив $GLOBALS содержит элементы для каждой глобальной переменной и доступен
    во всех областях видимости, поэтому его называют супер глобальным. Используя его, вы получите
    доступ к любому глобальному значению с помощью записи $ GLOBALS [name], где name — имя глобальной
    переменной (без знака доллара). Преимущество данного подхода в том, что при необходимости вы все еще
    можете создать на уровне функции отдельную переменную с именем $pdo. */
        
    catch  (PDOException $e) {
        $error  =  'Ошибка базы данных при подсчете шуток';
        include  'error.html.php';
        exit () ;
    }
    $row =  $result->fetch();
    return $row[0];
}
