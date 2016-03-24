<?php
    /*Волшебные кавычки - метод защиты от внедрения SQL-кода*/
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
        /*Пользователь заполнил форму и нажал кнопку "Отправить"*/
if (isset($_POST['joketext'])) { /*Проверяем наличие переменной joketext в запросе*/
    try {
        /*Параметризированный запрос - SQL-запрос, отправляющий серверу псевдопеременные, которые при
            формировании настоящего запроса заменяются необходимыми значениями.
            (непосредственно выполнения запроса в этот момент не происходит)*/

        $sql = 'INSERT INTO joke SET 
            joketext = :joketext, /* :joketext - псевдопеременная для параметризированного запроса*/
            jokedate = CURDATE()';  /*Спец. MySQL функция CURDATE, которая добавляет сегоднешнюю дату.*/
        $s = $pdo->prepare($sql); /*из объекта PDO($pdo) вызывается метод prepare которому в качестве аргумента
       передается SQL-запрос, который направляется серверу MySQL, чтобы подготовить его к последующему
       выполнению команд. Обработать запрос MySQL пока не в состоянии - ему не хватает значения для столбца joketext.
            Метод prepare возвращает объект PDOStatement (того самого типа,с помощью которого мы получаем результаты
            выполнения команды SELECT) и сохраняет его в переменную $s.*/

        /*Теперь, когда MySQL-сервер готов к выполнению запроса, ему можно отправить пропущенные значения,
        вызвав метод bindValue из объекта PDOStatement ($s).
            Метод bindValue вызывается при передаче каждого значения.*/
        $s->bindValue(':joketext', $_POST['joketext']); /*В качестве аргумента кроме самого значения $_POST['joketext'],
                        ему передается псевдопеременная :joketext, которую необходимо заменить.*/
            /*Сервер MySQL знает, что он получает содержимое отдельных переменных, а не SQL-код.
            Исчезает риск, что отправленные символы интерпретируются как команды на языке SQL.
            Таким образом, использование параметризированных запросов исключает уязвимости, связанные с внедрением
            SQL-кода.*/
        $s->execute(); /*из объекта PDOStatement вызывается метод execute, чтобы сервер MySQL смог выполнить запрос
                         с теми значениями, которые ему предоставили.*/
    }
    catch (PDOException $e){
        $error = 'Ошибка при добавлении шутки: ' . $e->getMessage();
        include 'error.html.php';
        exit();
    }
        /*Функция header предоставляет серверу средства для отправки специальных ответов и позволяет
        возвращать браузеру особые заголовки.*/
    header('Location: .'); /*отсылаем заголовок Location, чтобы объявить о перенаправлении.
                Точка . обозначает текущий документ/директорию т.е. нужно перезагрузить текущую директорию
                после добавления шутки в базу данных*/
    exit();
}
        /* Удаление шутки*/
if(isset($_GET['deletejoke'])){
    try{
        $sql = 'DELETE FROM joke WHERE id = :id';
        $s = $pdo->prepare($sql);
        $s->bindValue(':id', $_POST['id']);
        $s->execute();
    }
    catch (PDOException $e){
        $error = 'Ошибка при удалении шутки: ' . $e->getMessage();
        include 'error.html.php';
        exit();
    }
    header('Location: .');
    exit();
}
/*....................................................................*/

try{
    $sql = 'SELECT id, joketext FROM joke';
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
    $jokes[] = array('id'=>$row['id'],'text'=>$row['joketext']); /*$jokes - в данном случае, является массивом*/
}
include 'jokes.html.php';