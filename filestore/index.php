<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/magicquotes.inc.php';

/* .................................. Добавляем файл в БД ................................... */
if (isset($_POST['action']) and $_POST['action'] == 'upload') {
// Останавливаем скрипт,  если этот файл не был загружен,
    if (!is_uploaded_file($_FILES['upload']['tmp_name'])) {  /*Функция is_uploaded_file - проверяет, безопасен ли файл*/
        $error = 'Файл не был загружен!';
        include $_SERVER['DOCUMENT_ROOT'] . '/includes/error.html.php';
        exit();
    }
    $uploadfile = $_FILES['upload']['tmp_name'];
    $uploadname = $_FILES['upload']['name'];
    $uploadtype = $_FILES['upload']['type'];
    $uploaddesc = $_POST['desc'];
    $uploaddata = file_get_contents($uploadfile);

    include  $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';

    try {
        $sql = 'INSERT INTO filestore SET
            filename = :filename,
            mimetype = :mimetype,
            description = :description,
            filedata = :filedata';
        $s = $pdo->prepare($sql);
        $s->bindValue(':filename', $uploadname);
        $s->bindValue(':mimetype', $uploadtype);
        $s->bindValue(':description', $uploaddesc);
        $s->bindValue(':filedata', $uploaddata);
        $s->execute();
    }
    catch (PDOException $e) {
        $error = 'Ошибка при сохранении файла в базе данных!';
        include $_SERVER['DOCUMENT_ROOT'] . '/includes/error.html.php';
        exit();
    }

    header('Location: .');
    exit();
}
/* .......................................................................................... */

/* ................................... Скачивание файлов .................................... */
if (isset($_GET['action']) and
    ($_GET['action'] == 'view' or $_GET['action'] == 'download') and
    isset($_GET['id'])) {
        include  $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';

        try {
            $sql = 'SELECT filename, mimetype, filedata FROM filestore WHERE id = :id';
            $s = $pdo->prepare($sql);
            $s->bindValue(':id', $_GET['id']);
            $s->execute();
        }
        catch (PDOException $e) {
            $error = 'Ошибка при извлечении файла из базы данных.';
            include $_SERVER['DOCUMENT_ROOT'] . '/includes/error.html.php';
            exit();
        }

        $file = $s->fetch();
        if (!$file) {
            $error = 'Файл с указанным id не найден в базе данных!';
            include $_SERVER ['DOCUMENT_ROOT'] . '/includes/error.html.php';
            exit();
        }

        $filename = $file['filename'];
        $mimetype = $file['mimetype'];
        $filedata = $file['filedata'];
        $disposition = 'inline';

        if ($_GET['action'] == 'download') {        //Скачать файл
            $mimetype = 'application/octet-stream'; /*application/octet-stream - указывает старым браузерам, что
                                                                                          требуется начать загрузку*/
            $disposition = 'attachment'; /* Меняем значение inline на attachment в заголовке Content-disposition,
                                                                                                чтобы скачать файл*/
        }

    // Заголовок Content-type должен идти перед Content-disposition.
    header('Content-length: ' . strlen($filedata));  // Размер файла указывается в заголовке Content-length
            /*Функция strlen - возвращает длину заданной строки и с её помощью получают размер бинарных данных*/
    header("Content-type: $mimetype");   // Тип файла задается в заголовке Content-type
    header("Content-disposition; $disposition; filename=$filename"); // Имя файла передается заголовком Content-disposition

    echo $filedata;
    exit();
}
/* ......................................................................................... */
    if (isset($_POST['action']) and $_POST['action'] == 'delete' and
        isset($_POST['id'])) {

        include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';

        try {
            $sql = 'DELETE FROM filestore WHERE id = :id';
            $s = $pdo->prepare($sql);
            $s->bindValue(':id', $_POST['id']);
            $s->execute();
        }
        catch (PDOException $e) {
            $error = 'Ошибка при удалении файла из базы данных.';
            include $_SERVER['DOCUMENT_ROOT'] . '/includes/error.html.php';
            exit();
        }

        header('Location: .');
        exit();
    }

    include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';

    try {
        $result = $pdo->query('SELECT id, filename, mimetype, description FROM filestore');
    }
    catch  (PDOException $e) {
        $error = 'Ошибка при извлечении файла из базы данных.';
        include $_SERVER['DOCUMENT_ROOT'] . '/includes/error.html.php';
        exit();
    }

    $files = array();
    foreach ($result as $row) {
        $files[] = array(
            'id' => $row['id'],
            'filename' => $row['filename'],
            'mimetype' => $row['mimetype'],
            'description' => $row['description']);
    }

    include 'files.html.php';
