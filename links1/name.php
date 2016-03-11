<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
    <?php
        $firstname = $_GET['firstname'];
        $lastname = $_GET['lastname'];
        echo 'Добро пожаловать на наш веб-сайт, ' .
            htmlspecialchars($firstname, ENT_QUOTES, 'UTF-8') . ' ' .
            htmlspecialchars($lastname, ENT_QUOTES, 'UTF-8') . '!';

    /*    htmlspecialchars($firstName, ENT_QUOTES, 'UTF-8') . ' ' .
        htmlspecialchars($lastName, ENT_QUOTES, 'UTF-8') . '!';
     htmlspecialchars - преобразует символы < и > в &lt; и &gt; и браузер не может интерпретировать html как код.
       ENT_QUOTES - сообщает функции htmlspecialchars, что кроме прочих спец. символов, нужно преобразовывать еще одинарные и двойные кавычки.
       UTF-8 - какую кодировку нужно использовать для интерпретации заданного текста.
    */

    ?>
</body>
</html>
