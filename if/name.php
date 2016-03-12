<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
    <?php
        $name = $_REQUEST['name'];
        if($name == 'Кевин'){
            echo 'Добро пожаловать, о блистательный правитель!';
        }
        else{
            echo 'Добро пожаловать на наш сайт, ' . htmlspecialchars($name, ENT_QUOTES, 'UTF-8') . '!';
        }
    ?>
</body>
</html>