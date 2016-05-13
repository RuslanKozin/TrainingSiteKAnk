<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/magicquotes.inc.php';
$items = array(
    array('id' => '1', 'desc' => 'Канадско-австралийский словарь', 'price' => 24.95),
    array('id' => '2', 'desc' => 'Практически новый парашют (никогда нераскрывался)', 'price' => 1000),
    array('id' => '3', 'desc' => 'Песни группы Goldfish (набор из 2 CD)', 'price' => 19.99),
    array('id' => '14', 'desc' => 'Просто JavaScript (SitePoint)', 'price' => 39.95));

session_start();    //Создаем сессию
if (!isset($_SESSI0N['cart'])) {
    $_SESSION['cart'] = array();   /*Если переменной $cart нет,то инициализирует с помощью пустого массива,
                                    который представляет собой незаполненную корзину.*/
}

include 'catalog.html.php';

if (isset($_POST['action']) and $_POST['action'] == 'Купить') {
// Добавляем элемент в конец массива $_SESSION['cart'].
    $_SESSION['cart'][] = $_POST['id'];   /*Идентификатор товара добавляется в массив $_SESSION ['cart'] и отсылается
            браузеру на ту же страницу, но уже без данных, отправленных через форму. Таким образом, обновление
            страницы пользователем не приведет к повторному добавлению товара в корзину.*/
    header('Location: .');
    exit();
}

if (isset($_GET['cart'])) {         //Когда пользователь нажмет Просмотреть корзину
    $cart = array();
    $total = 0;
    foreach ($_SESSION['cart'] as $id) {   //Перебираем идентификаторы
        foreach ($items as $product) {          //Запускаем для каждого id и ищем товар с тем же id ($product['id']),
            if ($product['id'] == $id) {        //но уже в массиве $items.
                $cart[] = $product;             //Найденный товар помещается в массив $cart.
                $total += $product['price'];    /*Тем временем подсчитываем общию стоимость товаров в корзине.
                    Каждый раз, когда второй цикл foreach находит товар в корзине, он добавляет значение его цены
                    ($product['price']) к переменной $total. */
                break;  //Команда break останавливает выполнение второго цикла foreach, когда искомый товар найден.
            }
        }
    }
    include  'cart.html.php';
    exit();
}

if (isset($_POST['action']) and $_POST['action'] == 'Очистить корзину') {
    //Опустошаем массив $_SESSION['cart']
    unset($_SESSION['cart']);
    header('Location: ?cart');
    exit();
}
