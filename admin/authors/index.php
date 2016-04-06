<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/magicquotes.inc.php';

/* ..................... Добавление автора ....................... */
if (isset($_GET['add'])) {
    $pageTitle = 'Новый автор';
    $action = 'addform';
    $name = '';
    $email = '';
    $id = '';
    $button = 'Добавить автора';

    include 'form.html.php';
    exit();
}
if (isset($_GET['addform'])) {
    include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';

    try {
        $sql = 'INSERT INTO author SET 
                name = :name,
                email = :email';
        $s = $pdo->prepare($sql);
        $s->bindValue(':name', $_POST['name']);
        $s->bindValue(':email', $_POST['email']);
        $s->execute();
    }
    catch (PDOException $e) {
        $error = 'Ошибка при добавлении автора.';
        include 'error.html.php';
        exit();
    }
    header('Location: .');  /*отсылаем заголовок Location, чтобы объявить о перенаправлении.
                Точка . обозначает текущий документ/директорию т.е. нужно перезагрузить текущую директорию
                после добавления шутки в базу данных*/
    exit();
}
/*.................................................................*/

/* ........................ Редактирование авторов ........................... */
if (isset($_POST['action']) and $_POST['action'] == 'Редактировать') {
    include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';
    try {
        $sql = 'SELECT id, name, email FROM author WHERE id = :id';
        $s = $pdo->prepare($sql);  /*Метод prepare направлляет MySQL серверу псевдопеременную находящуюся в $sql
                    для подготовки выполнения команд, после возвращает объект PDOStatement и сохраняет в $s*/
        $s->bindValue(':id', $_POST['id']);  /*С помощью метода bindValue заменяем псевдопеременную :id на $_POST['id']*/
        $s->execute();  /*Метод execute говорит серверу MySQL выполнить запрос с предоставленными ему значениями*/
    }
    catch (PDOException $e) {
        $error = 'Ошибка при извлечении информации об авторе.' . $e->getMessage();
        include 'error.html.php';
        exit();
    }
    $row = $s->fetch();

    $pageTitle = 'Редактировать автора';
    $action = 'editform';
    $name = $row['name'];
    $email = $row['email'];
    $id = $row['id'];
    $button = 'Обновить информацию об авторе';
    include 'form.html.php';
    exit();
}
if (isset($_GET['editform'])) {
    include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';
    try {
        $sql = 'UPDATE author SET 
                name = :name,
                email = :email
                WHERE id = :id';
        $s = $pdo->prepare($sql);  /*Метод prepare направлляет MySQL серверу псевдопеременные находящиеся в $sql
                    для подготовки выполнения команд, после возвращает объект PDOStatement и сохраняет в $s*/
        $s->bindValue(':id', $_POST['id']);  /*С помощью метода bindValue заменяем псевдопеременную :id на $_POST['id']*/
        $s->bindValue(':name', $_POST['name']);
        $s->bindValue(':email', $_POST['email']);
        $s->execute();  /*Метод execute говорит серверу MySQL выполнить запрос с предоставленными ему значениями*/
    }
    catch (PDOException $e) {
        $error = 'Ошибка при обновлении записи об авторе.' . $e->getMessage();
        include 'error.html.php';
        exit();
    }
    header('Location: .');  /*отсылаем заголовок Location, чтобы объявить о перенаправлении.
                Точка . обозначает текущий документ/директорию т.е. нужно перезагрузить текущую директорию
                после добавления шутки в базу данных*/
    exit();
}
/*.............................................................................*/

/* ..................... Удаление автора ......................... */
if(isset($_POST['action']) and $_POST['action'] == 'Удалить') {  /*Если существует переменная $_POST['action'] -
        глобальный массив $_POST со значением action, and и значение переменной $_POST равно Удалить
    выполнить код ниже..*/
    include 'querydel.html.php';
    if (isset($_POST['action']) and $_POST['action'] == 'Да') {
        include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';  /*Связываемся с базой данных*/

        // (1) Получаем шутки, принадлежащие автору.
        try {
            /*Параметризированный запрос - SQL-запрос, отправляющий серверу псевдопеременные, которые при
            формировании настоящего запроса заменяются необходимыми значениями.
            (непосредственно выполнения запроса в этот момент не происходит)*/

            $sql = 'SELECT id FROM joke WHERE authorid = :id';
            $s = $pdo->prepare($sql);  /*Метод prepare направлляется MySQL серверу псевдопеременную находящуюся в $sql
                        для подготовки выполнения команд, после возвращает объект PDOStatement и сохраняет в $s*/
            $s->bindValue(':id', $_POST['id']);  /*С помощью метода bindValue заменяем псевдопеременную :id на $_POST['id']*/
            $s->execute();  /*из объекта PDOStatement вызывается метод execute, чтобы сервер MySQL смог выполнить запрос
                             с теми значениями, которые ему предоставили.*/
        }
        catch (PDOException $e) {
            $error = 'Ошибка при получении списка шуток, которые нужно удалить.' . $e->getMessage();
            include 'error.html.php';
            exit();
        }
        /*Необходимо получить список всех шуток конкретного автора по запросу SELECT и, пока идет перебор этого списка,
        выполннить для каждого элемента команду DELETE. Проблема в том, что нельзя приостановить работу сервера MySQL
        на полпути и попросить переключиться на команды DELETE, в то время как он возвращает результаты выполнения
        запроса SELECT.
            Это приведет к тому, что запросы на удаление завершатся ошибками.*/
            //Здесь нам и пригодится метод fetchAll.

        // (2) Все данные из запроса SELECT помещаем в массив $result.
        $result = $s->fetchAll();  /*Метод fetchAll - вызванный из заранее подготовленного выражения $s.
                Метод fetchAll извлекает из запроса весь набор результатов и помещает его в массив $result*/

        /*Теперь можно пройтись по массиву с помощью цикла foreach и извлечь каждую строку по очереди.*/

        // (3) Удаление записи о категориях шуток и перебор результирующего набора(данных) из SELECT.
        try {  /*Создаем параметризированный запрос с помощью SQL-кода, содержащего псевдопеременную.*/


            $sql = 'DELETE FROM jokecategory WHERE jokeid = :id';
            $s = $pdo->prepare($sql);

            /*Для каждой шутки.   Затем посредством цикла foreach перебираем результирующий набор, который вернул
                                  предыдущий запрос с командой SELECT. При этом для каждой шутки выполняется заранее
                                  подготовленное выражение DELETE, в которое на место псевдопеременной :id подставляется
                                  идентификаторы, хранящиеся внутри bindValue. */
            foreach ($result as $row) {
                $jokeId = $row['id'];
                $s->bindValue(':id', $jokeId); /*С помощью метода bindValue заменяем псевдопеременную :id на $jokeId*/
                $s->execute();  /*Метод execute говорит серверу MySQL выполнить запрос с предоставленными ему значениями*/
            }
        }
        catch (PDOException $e) {
            $error = 'Ошибка при удалении записей о категориях шутки.';
            include 'error.html.php';
            exit();
        }

        //Удалеляем шутки, принадлежащие автору.
        try {
            $sql = 'DELETE FROM joke WHERE authorid = :id';
            $s = $pdo->prepare($sql);
            $s->bindValue(':id', $_POST['id']);
            $s->execute();
        }
        catch (PDOException $e) {
            $error = 'Ошибка при удалении шуток, принадлежащих автору.';
            include 'error.html.php';
            exit();
        }

        //Удаляем имя автора.
        try {
            $sql = 'DELETE FROM author WHERE id = :id';
            $s = $pdo->prepare($sql);
            $s->bindValue(':id', $_POST['id']);
            $s->execute();
        }
        catch (PDOException $e) {
            $error = 'Ошибка при удалении автора.';
            include 'error.html.php';
            exit();
        }
        header('Location: .');
        exit();
    }
}
/*................................................................*/

//Выводим список авторов
include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php'; //подключаем файл соединение с базой данных

try {
    $result = $pdo->query('SELECT id, name FROM author');
}
catch (PDOException $e) {
    $error = 'Ошибка при извлечении авторов из базы данных!' . $e->getMessage();
    include 'error.html.php';
    exit();
}
foreach ($result as $row) {
    $authors[] = array('id' => $row['id'], 'name' => $row['name']);
}
include 'authors.html.php';