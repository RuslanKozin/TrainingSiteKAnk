<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/helpers.inc.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Последние шутки</title>
    <link rel="canonical" href="/recentjokes/">
</head>
<body>
    <р>Вот самые свежие шутки в базе данных:</р>
    <?php foreach ($jokes  as  $joke): ?>
        <?php markdownout($joke['text']); ?>
    <?php endforeach; ?>
</body>
</html>