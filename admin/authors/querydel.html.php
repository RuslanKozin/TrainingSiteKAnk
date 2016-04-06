<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Удаление автора</title>
</head>
<body>

        <h1>Вы действительно хотите удалить автора из списка ?</h1>
            <form action="" method="post">
                <input type="hidden" name="id" value="<?php echo $_POST['id'];?>">
                <input type="submit" name="action" value="Да">
                <input type="submit" name="action" value="Нет">
                    <!--Обе кнопки имеют одинаковое значение атрибута name(action),чтобы исходя из
                    отправленных данных ($_POST['action']) контроллер мог определить, какая из них была нажата.-->
            </form>

</body>
</html>