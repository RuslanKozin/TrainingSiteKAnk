<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/helpers.inc.php';/*Подключаем htmlspecialchars*/?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Управление авторами</title>
</head>
<body>
    <h1>Управление авторами</h1>
    <p><a href="?add">Добавить нового автора</a></p>
    <ul>
         <?php foreach ($authors as $author):?>
            <li>
                <form action="" method="post">
                    <div>
                        <?php htmlout($author['name']);?>
                        <input type="hidden" name="id" value="<?php echo $author['id'];?>">
                        <input type="submit" name="action" value="Редактировать">
                        <input type="submit" name="action" value="Удалить">
                            <!--Обе кнопки имеют одинаковое значение атрибута name(action),чтобы исходя из
                            отправленных данных ($_POST['action']) контроллер мог определить, какая из них была нажата.-->
                    </div>
                </form>
            </li>
        <?php endforeach;?>
    </ul>
    <p><a href="..">Вернуться на шлавную страницу</a></p>
    <?php include '../logout.inc.html.php'; ?>  /*Подключаем файл выхода из системы*/
</body>
</html>
