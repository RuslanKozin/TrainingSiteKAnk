<?php
            /*Вспомогательные функции*/
function html($text) {
    return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
}
function htmlout($text) {  /*htmlout принимает значение от функции html и выводит его на страницу*/
    echo html($text);
}