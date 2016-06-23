<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/helpers.inc.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Репозиторий файлов на основе PHP/MySQL</title>
</head>
<body>
<h1>Репозиторий файлов на основе PHP/MySQL</h1>
    <form action="" method="post" enctype="multipart/form-data">
        <div>
            <label for="upload">3агрузить файл:
            <input type="file" id="upload" name="upload"></label>
        </div>
        <div>
            <label for="desc">Описание файла:
                <input type="text" id="desc" name="desc" maxlength="255">
            </label>
        </div>
        <div>
            <input type="hidden" name ="action" value= "upload">
            <input type="submit" value="Загрузить">
        </div>
    </form>

    <?php if (count($files) >0): ?>

    <p>B базе данных хранятся следующие файлы:</p>
    <table>
        <thead>
            <tr>
                <th>Имя файла</th>
                <th>Тип</th>
                <th>Описание</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($files as $f): ?>
            <tr>
                <td>
                    <a href="?action=view&amp;id=<?php htmlout($f['id']); ?>"><?php htmlout($f['filename']); ?></a>
                </td>
                <td><?php htmlout($f['mimetype']); ?></td>
                <td><?php htmlout($f['description']); ?></td>
                <td>
                    <form action="" method="get">
                        <div>
                            <input type="hidden" name="action" value="download"/>
                            <input type="hidden" name="id" value="<?php htmlout($f['id']); ?>"/>
                            <input type="submit" value="Скачать"/>
                        </div>
                    </form>
                </td>
                <td>
                    <form action="" method="post">
                        <div>
                            <input type="hidden" name="action" value="delete"/>
                            <input type="hidden" name="id" value="<?php htmlout($f['id']); ?>"/>
                            <input type="submit" value="Удалить"/>
                        </div>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php endif; ?>
</body>
</html>

