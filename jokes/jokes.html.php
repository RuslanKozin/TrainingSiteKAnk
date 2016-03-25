<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Список шуток</title>
</head>
<body>
    <p><a href="?addjoke">Добавьте собственную шутку</a></p>
    <p>Вот все шутки, которые есть в базе данных:</p>
    <?php foreach ($jokes as $joke): ?>
        <form action="?deletejoke" method="post">
            <blockquote>
                <p>
                    <?php echo htmlspecialchars($joke['text'], ENT_QUOTES, 'UTF-8');?>
                    <input type="hidden" name="id" value="<?php echo $joke['id'];?>">
                    <input type="submit" value="Удалить">
                    (автор <a href="mailto:<?php echo htmlspecialchars($joke['email'], ENT_QUOTES, 'UTF-8');?>">
                                <?php echo htmlspecialchars($joke['name'], ENT_QUOTES, 'UTF-8');?>
                           </a>)
                </p>
            </blockquote>
        </form>
    <?php endforeach; ?>
</body>
</html>
