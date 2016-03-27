#Код создания простой таблицы

CREATE TABLE joke (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  joketext TEXT,
  jokedate DATE NOT NULL
) DEFAULT CHARACTER SET utf8 ENGINE=InnoDB;

#Узнать структуру таблицы
DESCRIBE joke

#Добавляем шутки в таблицу

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

#Обновление даты шутки в базе данных

UPDATE joke SET jokedate = "2012-04-01" WHERE id="1";

#Добавить столбец в таблицу

ALTER TABLE joke ADD COLUMN authorname VARCHAR(255)
  #Добавили в таблицу joke столбец под названием authorname и типом VARCHAR 255 - строка переменной длины не более 255 символов

#DISTINCT - предотвращает вывод дублирующихся строк
  SELECT DISTINCT authorname, authotmail FROM joke

#Удаляем столбец в таблице
ALTER TABLE joke DROP COLUMN authorname
  #Удаляем из таблицы joke столбец authorname

  #Создаем промежуточную таблицу
CREATE TABLE jokecategory ( /*Создаем таблицу с именем jokecategory*/
  jokeid INT NOT NULL,    /*создаем ячейку jokeid, INT(integer) - целые числа, NOT NULL - не должно быть пустым*/
  categoryid INT NOT NULL,  /*создаем ячейку categoryid, INT - целые числа, NOT NULL - не должно быть пустым*/
  PRIMARY KEY (jokeid, categoryid)  /*Первичный ключ для ячеек jokeid и categoryid*/
)DEFAULT CHARACTER SET utf8 ENGINE=InnoDB  /*Кодировка по умолчанию utf8 и движок для хранения инф. бызы данных*/