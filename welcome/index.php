<?php
if(!isset($_REQUEST['firstname'])){
    include 'form.html.php';
}
else{
    $firstname = $_REQUEST['firstname'];
    $lastname = $_REQUEST['lastname'];
        if($firstname == 'Kevin' and $lastname == 'Yank'){
            $output = 'Добро пожаловать, о блистательный правитель!';
        }
        else{
            $output = 'Добро пожаловать на нащ веб-сайт, ' .
            htmlspecialchars($firstname, ENT_QUOTES, 'UTF-8') . ' ' .
            htmlspecialchars($lastname, ENT_QUOTES, 'UTF-8') . '!';
        }
    include 'welcome.html.php';
}