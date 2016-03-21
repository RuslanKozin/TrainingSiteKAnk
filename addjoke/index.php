<?php
if (get_magic_quotes_gpc()) {
    $process = array(&$_GET, &$_POST, &$_COOKIE, &$_REQUEST);
    while (list($key, $val) = each($process)) {
        foreach ($val as $k => $v) {
            unset($process[$key][$k]);
            if (is_array($v)) {
                $process[$key][stripslashes($k)] = $v;
                $process[] = &$process[$key][stripslashes($k)];
            } else {
                $process[$key][stripslashes($k)] = stripslashes($v);
            }
        }
    }
    unset($process);
}
    /* Проверяем нажата ли кнопка "Добавить шутку"  */
if (isset($_GET['addjoke'])) { /* если существует элемент/переменная addjoke в глоб. массиве GET */
    include 'form.html.php'; /* если да, то выводим форму добавления шутки */
    exit();
}

/*... Устанавливаем соединение с базой данных ...*/
try{
    /*Ключ. слово new говорит интерпретатору, что нужно создать новый объект.
      Поставив пробел и указав имя класса, вы сообщаете PHP какого типа объект нужен.
      PDO - встроенный класс в PHP.*/
    $pdo = new PDO('mysql:host=localhost;dbname=ijdb', 'ijdbuser', 'mypassword');
        /*Настройка соединения*/
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);/*Вызываем метод setAttribute объекта PDO,
      чтобы экземпляр PDO генерировал исключение PDOException каждый раз, когда он не в состоянии выполнить запрос*/
    $pdo->exec('SET NAMES "utf8"'); /*Метод exec позволяет вводить SQL-запросы(команды) и получать результат*/
        /* С помощью метода exec устанавливаем кодировку соединения с базой данных */
}
catch (PDOException $e){ /*(Исключение)Блок catch перехватит объект PDOException и поместит его в переменную $e.*/
        /*Объект PDOException - разновидность исключений, которую выбрасывает new PDO.*/
    $error = 'Невозможно подключиться к серверу баз данных.';
                                /*Внутри блока переменной $error будет присвоено сообщение,
                                информирующее пользователя о том, что произошло.*/
    include 'error.html.php'; /*Подключаем шаблон на котором отображается значение $error.*/
    exit(); /*Завершение работы скрипта.*/
}
/*
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        PDO:: - указывает на то, что константы не встроены в язык PHP и составляют часть используемого класса PDO.
        PDO::ATTR_ERRMODE - атрибут управляющий выводом ошибок
        PDO::ERRMODE_EXCEPTION - режим выброса исключений
        Строка (PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION) говорит, что мы хотим задать атрибуту, управляющему выводом ошибок
        (PDO:: ATTR_ERRMODE), режим выброса исключений  (PDO::ERRMODE_EXCEPTION)
*/

/*.............................................................*/

if (isset($_POST['joketext'])) {
    try {
        $sql = 'INSERT INTO joke SET joketext = :joketext, jokedate = CURDATE()';
        $s = $pdo->prepare($sql);
        $s->bindValue(':joketext', $_POST['joketext']);
        $s->execute();
    }
    catch (PDOException $e){
        $error = 'Ошибка при добавлении шутки: ' . $e->getMessage();
        include 'error.html.php';
        exit();
    }
    header('Locatoin: .');
    exit();
}

try{
    $sql = 'SELECT joketext FROM joke';
    $result = $pdo->query($sql); /*вытаскиваем данные из базы данных и сохраняем в переменную result*/
    /*Метод query похож на метод ехес тем, что в качестве аргумента принимает SQL-запрос, направленный
      базе данных. Отличие заключается в том, что он возвращает объект PDOStatement, который представляет
      собой результирующий набор, иначе говоря, список всех строк (записей), полученных в результате запроса*/
}
catch(PDOException $e){ /*(Исключение)Блок catch перехватит объект PDOException и поместит его в переменную $e.*/
        /*Объект PDOException - разновидность исключений, которую выбрасывает new PDO.*/
    $error = 'Ошибка при извлечении шуток: ' . /*Внутри блока переменной $error будет присвоено сообщение,
                                                    информирующее пользователя о том, что произошло.*/
        $e->getMessage(); /*Метод getMessage вызывается из объекта, хранящегося в переменной  $е,
        и вставляет возвращенное им значение в конец сообщения об ошибке, используя оператор конкатенации (.)*/
    include 'error.html.php'; /*Подключаем шаблон на котором отображается значение $error(ошибки).*/
    exit();
}
    /*Цикл while используем для поочередной обработки(вывода) строк результирующего набора(базы данных)*/
while($row = $result->fetch()){ /*Метод fetch возвращает строки результирующего набора в виде массива*/
    $jokes[] = $row['joketext'];
}
include 'jokes.html.php';