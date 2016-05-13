<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/magicquotes.inc.php';
$items = array(
    array('id' => '1', 'desc' => 'Канадско-австралийский словарь', 'price' => 24.95),
    array('id' => '2', 'desc' => 'Практически новый парашют (никогда нераскрывался)', 'price' => 1000),
    array('id' => '3', 'desc' => 'Песни группы Goldfish (набор из 2 CD)', 'price' => 19.99),
    array('id' => '14', 'desc' => 'Просто JavaScript (SitePoint)', 'price' => 39.95));

session_start();    //Создаем сессию
if (!isset($_SESSI0N['cart'])) {
    $_SESSION['cart'] = array();
}

include 'catalog.html.php';
