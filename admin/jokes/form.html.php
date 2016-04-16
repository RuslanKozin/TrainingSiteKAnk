<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/helpers.inc.php';  ?>
<!DOCTYPE html>
<html  lang="en">
<head>
    <meta charset="utf-8">
    <title><?php htmlout($pageTitle); ?></title>
    <style type="text/css">
        textarea  {
            display: block;
            width: 100%;
        }
    </style>
</head>
<body>
    <hl><?php htmlout($pageTitle); ?></hl>
    <form action="?<?php htmlout($action); ?>" method="post">
        <!-- ................... Область ввода текста шутки ..................... -->
        <div>
            <label for="text">Введите сюда свою шутку:</label>
            <textarea id="text" name="text" rows="3" cols="40"><?php htmlout($text); ?></textarea>
        </div>
        <!-- .................................................................... -->

        <!-- ................... Область выбора имя автора ...................... -->
        <div>
            <label for="author">Автор:</label>
            <select name="author" id="author">
                <option value="">Выбрать</option>
                <?php foreach ($authors as $author): ?>
                    <option value="<?php htmlout($author['id']); ?>"<?php
                        if ($author['id'] == $authorid) {
                            echo ' selected';  /*Добавляем атрибут selected в тег option, если идентификатор
                             соответствуюшего автора $author['id'] совпадает с полем $authorid редактируемой шутки.*/
                        }
                        ?>><?php htmlout ($author['name']);  ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <!-- .................................................................... -->

        <!-- .................... Область выбора категории ...................... -->
        <fieldset>
            <legend>Категории:</legend>
            <?php foreach ($categories as $category): ?>
                <div>
                    <label for="category<?php htmlout($category['id']); ?>">
                        <input type="checkbox" name="categories[]"   /*Массив categories[] нужен для отправки
                                                                        лемента формы как части массива*/
                            id="category<?php htmlout($category['id']); ?>"
                            value="<?php htmlout($category['id']); ?>"<?php  /*Задаем id соответствующей категории*/
                                if ($category['selected']) {  //Если шутка из соответствующей категории, то
                                    echo ' checked';          //укажем атрибут selected
                                }
                            ?>><?php htmlout($category['name']); ?>
                    </label>
                </div>
            <?php endforeach; ?>
        </fieldset>
        <!--.......................................................................-->
        <div>
            <input type="hidden" name="id" value="<?php htmlout($id); ?>">
            <input type="submit" value="<?php htmlout($button); ?>">
        </div>
    </form>
</body>
</html>
