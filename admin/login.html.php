<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/helpers.inc.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Вход</title>
</head>
<body>
    <hl>Вход</hl>
    <р>Пожалуйста, войдите в систему, чтобы просмотреть страницу, к которой вы обратились.</р>
    <?php if (isset($loginError)): ?>
        <p><?php htmlout ($loginError); ?></p>
    <?php endif; ?>
    <form action="" method="post">
        <div>
            <label for="email">Email: <input type="text" name="email" id="email"></label>
        </div>
        <div>
            <label for="password">Пароль: <input type="password" name="password" id="password"></label>
        </div>
        <div>
            <input type="hidden" name="action" value="login">
            <input type="submit" value="Войти">
        </div>
    </form>
<p><a href="/admin/">Вернуться на главную страницу</a></p>
</body>
</html>

