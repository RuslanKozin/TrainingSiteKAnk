<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/helpers.inc.php'; ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Управление шутками</title>
</head>
<body>
    <h1>Управление шутками</h1>
    <p><a href="?add">Добавить новую шутку</a></p>
    <form action="" method="get">  <!--Метод GET в атрибуте method дает возможность добавлять результаты поиска в закладки,
                            поскольку значения формы в этом случае будут представлять часть адреса URL в строке запроса-->
        <p>Вывести шутки, которые удовлетворяют следующим критериям:</p>
        <div>
            <label for="author">По автору:</label>
            <select name="author" id="author">
                <option value="">Любой автор</option>  <!--Раскрывающийся список начинается элементом option с пустым
                    атрибутом value, что позволяет исключить поле из критериев поиска-->
                <?php foreach ($authors as $author): ?>
                    <option value="<?php htmlout($author['id']);?>">  <!--Идентификатор автора-->
                        <?php htmlout($author['name']);?>   <!-- Имя автора -->
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label for="category">По категориям:</label>
            <select name="category" id="category">
                <option value="">Любая категория</option>  <!--Раскрывающийся список начинается элементом option с пустым
                атрибутом value, что позволяет исключить поле из критериев поиска.-->
                <?php foreach ($categories as $category): ?>
                    <option value="<?php htmlout($category['id']);?>">  <!--Идентификатор категории-->
                        <?php htmlout($category['name']);?>     <!-- Название категории -->
                    </option>
                <?php endforeach;?>
            </select>
        </div>
        <div>
            <label for="text">Содержит текст:</label>
            <input type="text" name="text" id="text">
        </div>
        <div>
            <input type="hidden" name="action" value="search">
            <input type="submit" value="Искать">
        </div>
    </form>
    <p><a href="..">Вернуться на главную страницу</a></p>
</body>
</html>
