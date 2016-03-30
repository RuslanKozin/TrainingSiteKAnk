<?php
            /*Вспомогательные функции*/
    /*Функция для вывода списка шуток, добавленных посетителями*/
function html($text) {
    return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
}
    /*Функция htmlout принимает значение от функции html и выводит его на страницу*/
function htmlout($text) {
    echo html($text);
}