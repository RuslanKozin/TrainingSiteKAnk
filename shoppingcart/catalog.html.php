<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/helpers.inc.php'; ?>
    <!DOCTYPE html>
    <html  lang="en">
    <head>
        <meta charset="utf-8">
        <title>Каталог товаров</title>
        <style>
            table {
                border-collapse: collapse;
            }
            td, th {
                border:1px solid;
            }
        </style>
    </head>
    <body>
        <p>Ваша корзина содержит <?php
            echo count($_SESSION['cart']); ?> элементов.</p>    <!--Функция count позволяет вывести количество элементов
                    в массиве, который хранится в переменной $_SESSION['cart']. -->
        <p><a href="?cart">Просмотреть корзину</a></p>      <!--Ссылка, отображающая содержимое корзины пользователя.
        В системе, которая поддерживает работу с платежами, вы могли бы назвать ее Перейти к оформлению заказа. -->
        <table border="l">
        <thead>
            <tr>
                <th>Описание товара</th>
                <th>Цена</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($items as $item): ?>
                <tr>
                    <td><?php htmlout ($item['desc']); ?></td>
                    <td>
                        $<?php echo number_format($item['price'], 2); ?>    <!--Функция number_format помогает вывести
                            цену с двумя знаками после запятой.-->
                    </td>
                    <td>
                        <form action="" method="post">    <!--Форма с кнопкой Купить,  представленная для каждого
                            товара из списка, отправляет уникальный идентификатор соответствующего элемента. -->
                            <div>
                                <input type="hidden" name="id" value="<?php htmlout($item['id']); ?>">
                                <input type="submit" name="action" value="Купить">
                            </div>
                        </form>
                    </td>
                </tr>
            <?php endforeach;  ?>
        </tbody>
        </table>
        <p>Все цены указаны в тугриках.</p>
</body>
</html>

