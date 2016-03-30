<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/helpers.inc.php'; ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Список шуток</title>
</head>
<body>
    <p><a href="?addjoke">Добавьте свою собственную шутку</a></p>
    <p>Вот все шутки, которые есть в базе данных:</p>
    <?php foreach ($jokes as $joke): ?>
        <form action="?deletejoke" method="post">
            <blockquote>
                <p>
                    <?php htmlout($joke['text']);?>
                    <input type="hidden" name="id" value="<?php echo $joke['id'];?>">
                    <input type="submit" value="Удалить">
                        (автор <a href="mailto:<?php htmlout($joke['email']);?>">
                                    <?php htmlout($joke['name']);?>
                                </a>)
                </p>
            </blockquote>
        </form>
    <?php endforeach; ?>
</body>
</html>

