<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/helpers.inc.php';?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php htmlout($pageTitle);?></title>
</head>
<body>
    <h1><?php htmlout($pageTitle);?></h1>
    <form action="?<?php htmlout($action);?>" method="post">
        <div>
            <label for="name">Имя: <input type="text" name="name" id="name" value="<?php htmlout($name);?>"></label>
        </div>
        <div>
            <label for="email">Электронная почта: <input type="text" name="email" id="email" value="<?php htmlout($email);?>"></label>
        </div>
        <div>
            <input type="hidden" name="id" value="<?php htmlout($id);?>">
            <input type="submit" value="<?php htmlout($button);?>">
        </div>
    </form>
</body>
</html>
