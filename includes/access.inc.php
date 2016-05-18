<?php

function userIsLoggedIn() {
    if (isset($_POST['action']) and $_POST['action'] == 'login') {
            /*Первым делом проверям, отправлена ли форма для входа в систему*/
        if (!isset($_POST['email']) or $_POST['email'] == '' or
            !isset($_POST['password']) or $_POST['password'] == '') {
                $GLOBALS['loginError'] = 'Пожалуйста, заполните оба поля';
                return FALSE;
        }

        $password = md5($_POST['password'] . 'ijdb');

        if (databaseContainsAuthor($_POST['email'], $password)) {  /*если пользователь заполнил форму*/
            session_start();
            $_SESSION['loggedIn'] = TRUE;
            $_SESSION['email'] = $_POST['email'];
            $_SESSION['password'] = $password;
            return TRUE;
        }
        else {
            session_start();
            unset($_SESSION['loggedIn']);
            unset($_SESSION['email']);
            unset($_SESSION['password']);
            $GLOBALS['loginError'] = 'Указан неверный адрес электронной почты или пароль.';
            return FALSE;
        }
    }

    if (isset($_POST['action']) and $_POST['action'] == 'logout') {
        session_start();
        unset($_SESSION['loggedIn']);
        unset($_SESSION['email']);
        unset($_SESSION['password']);
        header('Location: ' . $_POST['goto']);
        exit();
    }
        /*Проверка: находится ли пользователь в системе*/
    session_start();
    if (isset($_SESSION['loggedIn'])) {
        return databaseContainsAuthor($_SESSION['email'], $_SESSION['password']);
    }
}

function databaseContainsAuthor($email, $password) {
    include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';

    try {
        $sql = 'SELECT COUNT(*) FROM author WHERE email = :email AND password = :password';
        $s = $pdo->prepare($sql);
        $s->bindValue(':email', $email);
        $s->bindValue(':password', $password);
        $s->execute();
    }
    catch (PDOException $e) {
        $error = 'Ошибка при поиске автора.' . $e->getMessage();
        include 'error.html.php';
        exit();
    }

    $row = $s->fetch();   /*Подсчет количество записей в таблице author, у которых указанный адрес и пароль совпадают*/

    if ($row[0] > 0) {
        return TRUE;
    }
    else {
        return FALSE;
    }
}

function userHasRole($role) {
    include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';

    try {
        $sql = "SELECT COUNT(*) FROM author
                INNER JOIN authorrole ON author.id = authorid 
                INNER JOIN role ON roleid = role.id 
                WHERE email = :email AND role.id = :roleid";
        $s = $pdo->prepare($sql);
        $s->bindValue(':email', $_SESSION['email']);
        $s->bindValue(':roleid', $role);
        $s->execute();
    }
    catch (PDOException $e) {
        $error = 'Ошибка при поиске ролей, назначенных автору.' . $e->getMessage();
        include 'error.html.php';
        exit();
    }

    $row = $s->fetch();

    if ($row[0] > 0) {
        return TRUE;
    }
    else {
        return FALSE;
    }
}