Задание:

Имеются следующие ресурсы:
Список записей блога: https://jsonplaceholder.typicode.com/posts
Комментарии к записям: https://jsonplaceholder.typicode.com/comments

Требуется:

1. Создать схему БД для хранения записей и комментариев к ним. SQL-запросы для создания БД поместить в отдельный файл.

2. Создать PHP скрипт, который скачает список записей и комментариев к ним и загрузит их в БД. По завершению загрузки, вывести в консоль надпись: "Загружено Х записей и Y комментариев"

3. Создать HTML-форму поиска записей по тексту комментария (поле ввода и кнопка "Найти"). Пример: при вводе "laudanti" нужно вывести все записи, в комментариях к которым есть эта строка. (имеется в этой записи https://jsonplaceholder.typicode.com/posts/6/comments). Поиск должен работать при вводе минимум 3-х символов. В результатах поиска вывести заголовок записи и комментарий с искомой строкой.

Описание выполненной работы:

1. Схема базы данных находится в файле schema.sql. Инициализация БД происходит в момент загрузки страницы index.php.

<img width="469" alt="image" src="https://github.com/user-attachments/assets/feaba717-1063-430c-b65b-fd9385ad376a">

2.Скачивание списка записей и комментариев происходит при загрузке страницы index.php. Результат выводится в консоли.

<img width="1236" alt="image" src="https://github.com/user-attachments/assets/30d0c72f-178d-4bbc-9ebf-211861095fc8">

3. На странице index.php есть текстовое поле и кнопка "Найти". По нажатию на кнопку проверяется условие "есть не менее 3-х символов", если условие выполнилось, то происходит отправка ее содержимого на обработку в файл BlogManager.php.

<img width="429" alt="image" src="https://github.com/user-attachments/assets/96e8dcab-0ea1-405e-8992-728f06d8cc90">

<img width="815" alt="image" src="https://github.com/user-attachments/assets/36a84b24-704f-43ea-a46d-5eb9c0d993c3">
