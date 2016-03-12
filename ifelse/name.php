<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
    <?php
        $firstname = $_REQUEST['firstname'];
        $lastname = $_REQUEST['lastname'];
        if($firstname == 'Кевин' and $lastname == 'Янк'){
            echo 'Добро пожаловать, о блистательный правитель!';
        }
        else{
            echo 'Добро пожаловать на наш сайт веб-сайт, ' .
                htmlspecialchars($firstname, ENT_QUOTES, 'UTF-8') . ' ' .
                htmlspecialchars($lastname, ENT_QUOTES, 'UTF-8') . '!';
        }
    ?>
</body>
</html>