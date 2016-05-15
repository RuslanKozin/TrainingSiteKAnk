<form action="" method="post">
    <div>       /*Используется скрытое поле с именем action, которое сообщает о намерениях пользователя.
                Поле goto указывает на то, куда необходимо перенаправить пользователя, который только что вышел
                из системы.*/
        <input type="hidden" name="action" value="logout">
        <input type="hidden" name=ngoto" value="/admin/">
        <input type="submit" value="Выйти">
    </div>
</form>
