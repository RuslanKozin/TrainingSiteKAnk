/*Код создания простой таблицы*/

CREATE TABLE joke (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  joketext TEXT,
  jokedate DATE NOT NULL
) DEFAULT CHARACTER SET utf8 ENGINE=InnoDB;

/*Узнать структуру таблицы*/
DESCRIBE joke

/*Добавляем шутки в таблицу*/

INSERT INTO joke SET
joketext = 'Зачем цыпленок перешел дорогу? Чтобы попасть на другую сторону',
jokedate = '2013-04-01';

INSERT INTO joke (joketext, jokedate)
VALUE ("Knock-knock! Who\'s there? Boo! "Boo" who? Don\'t cry; it\'s only a joke!",
"2012-04-01");

INSERT INTO joke
(joketext, jokedate) VALUE (
'"Королеве - подвески, Констанции - подвязки, Портосу - подтяжки...", -
повторял, чтобы не перепутать, д''Артаньян по дороге в Англию.',
"2012-04-01")


/*................... SQL-запросы через PHP .........................*/

/*Обновление даты шутки в базе данных*/

UPDATE joke SET jokedate = "2012-04-01" WHERE id="1";

/*Добавить столбец в таблицу*/

ALTER TABLE joke ADD COLUMN authorname VARCHAR(255)
  /*Добавили в таблицу joke столбец под названием authorname и типом VARCHAR 255 - строка переменной длины не более 255 символов*/

/*DISTINCT - предотвращает вывод дублирующихся строк*/
  SELECT DISTINCT authorname, authotmail FROM joke
/*....................................................................................................*/

/*Удаляем столбец в таблице*/
ALTER TABLE joke DROP COLUMN authorname
  /*Удаляем из таблицы joke столбец authorname*/
/*.....................................................................................................*/

  /*Создаем промежуточную таблицу*/
CREATE TABLE jokecategory ( /*Создаем таблицу с именем jokecategory*/
  jokeid INT NOT NULL,    /*создаем ячейку jokeid, INT(integer) - целые числа, NOT NULL - не должно быть пустым*/
  categoryid INT NOT NULL,  /*создаем ячейку categoryid, INT - целые числа, NOT NULL - не должно быть пустым*/
  PRIMARY KEY (jokeid, categoryid)  /*Первичный ключ для ячеек jokeid и categoryid*/
)DEFAULT CHARACTER SET utf8 ENGINE=InnoDB  /*Кодировка по умолчанию utf8 и движок для хранения инф. бызы данных*/
/*....................................................................................................*/

  /*Вывод с нескольких таблиц*/

  /*(Выводим список всех шуток в категории "О д'Артаньяне")*/
SELECT joketext     /*Выбираем ячейку joketext */
FROM joke INNER JOIN jokecategory  /*из таблицы joke внутренне объединяем с таблицей jokecategory*/
    ON joke.id = jokeid   /*условие объединения: равенство значений ячеек id таблицы joke и jokeid таблицы jokecategory*/
INNER JOIN category   /*полученный результат внутренне объединяем с таблицей category*/
    ON categoryid = category.id  /*условия объединения: равенство ячеек categoryid из таблицы jokecategory и
                                  ячейки id из таблицы category*/
WHERE name = "о д'Артаньяне"    /*Где в ячейки name есть "о д'Артаньяне"*/
/*....................................................................................................*/

  /*Выводим список категорий, в которых содержатся шутки, начинающиеся словами "сколько адвокатов"*/

SELECT name       /*Выбираем ячейку name*/
FROM joke INNER JOIN jokecategory   /*ИЗ таблицы joke внутренне объединив с таблицей jokecategory*/
    ON joke.id = jokeid   /*условие объедининия: равенство значений ячеек id таблицы joke и jokeid таблицы jokecategory*/
INNER JOIN category     /*полученный результат внутренне объединяем с таблицей category*/
    ON categoryid = category.id   /*условие объединения: равенство ячеек categoryid таблицы jokecategory и
                                  id таблицы category*/
WHERE joketext LIKE "Сколько адвокатов"   /*ГДЕ в ячейки joketext есть слова "Сколько адвокатов"*/
/*....................................................................................................*/

  /*Выводим имена всех авторов, которые добавили шутки о д'Артаньяне*/
SELECT author.name    /*Выбираем ячейку name из таблицы author*/
FROM joke INNER JOIN author   /*внутренне объединяем таблицы joke и author*/
    ON authorid = author.id   /*условие объединения: равенство значений ячеек authorid из таблицы joke и
                              ячейки id из таблицы author*/
INNER JOIN jokecategory   /*полученный результат внутренне объединяем с таблицей jokecategory*/
    ON joke.id = jokeid   /*условие объединения: равенство значений ячеек joke таблицы joke и jokeid из таблицы jokecategory*/
INNER JOIN category     /*полученные рузельтат внутренне объединяем с таблицей category*/
    ON categoryid = category.id   /*условия объединения: равенство значений ячеек categoryid таблицы jokecategory
                                  и ячейки id таблицы category*/
WHERE category.name = "о д'Артаньяне"   /*ГДЕ в ячейке name таблицы category есть слова "о д'Артаньяне"
                                        иными словами ГДЕ категория о д'Артаньяне*/