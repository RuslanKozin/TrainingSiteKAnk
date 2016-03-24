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

UPDATE joke SET jokedate = "2012-04-01" WHERE id="";

#Добавить столбец в таблицу

ALTER TABLE joke ADD COLUMN authorname VARCHAR(255)
  #Добавили в таблицу joke столбец под названием authorname и типом VARCHAR 255 - строка переменной длины не более 255 символов