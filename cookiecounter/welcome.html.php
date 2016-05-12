<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/helpers.inc.php'; ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Счетчик cookie</title>
</head>
<body>
    <p>
        <?php
            if ($visits > 1) {
                echo "Номер данного поседения: $visits.";
            }
            else {
                //Первое посещение
                echo 'Добро пожаловать на мой веб-сайт! Кликните здесь, чтобы узнать больше!';
            }
        ?>
    </p>
</body>
</html>
