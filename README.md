# Реализация шаблона CRUD

## Цель работы:
Разработать и реализовать клиент-серверную информационную систему, реализующую механизм CRUD.

## Задание:
- добавление текстовых заметок в общую ленту
- реагирование на чужие заметки (лайки)

## Пользовательский интерфейс

Комментарии пользователей![input.png](screens/page.png)

Форма ввода комментариев![output.png](screens/addcom.png)


##  Пользовательский сценарий работы

#### API сервера и хореография
Сервер использует HTTP POST запросы с полями заголовка и текста комментария.

**Функция добавления комментариев на сайт:**
с помощью POST запроса отправляются такие данные как: дата, заголовок и текст комментария.

**Функция вывода комментариев на сайте:**
из базы данных берётся только 100 последних комментариев (их дата добавления, заголовок и текст) и выводится на страницу.

**Функция редактирования комментариев на сайте:**
если пользователь нажал на кнопку редактирования комментария, в базе данных выбирается запись с соответствующим id. Пользователь меняет данные комментария во всплывающем окне, нажимает кнопку "Обновить" и через sql-запрос UPDATE меняются данные и в базе данных.

**Функция удаления комментариев на сайте:**
если пользователь нажал на кнопку удаления комментария, в базе данных выбирается запись с соответствующим id. Во всплывающем окне пользователь может подтвердить удаление либо отменить его. Если нажал на кнопку подтверждения, то запись с соответствующим id удаляется из базы данных через sql-запрос DELETE.
#### Пользовательский сценарий работы
При входе на страницу пользователь видит ленту комментариев и кнопку (плюсик) для добавления комментария.

## Структура базы данных
![data.png](screens/data.png)

- **id** : INT(10), PRIMARY KEY, AUTO_INCREMENT
  (уникальный идентификатор комментария)
- **name**: VARCHAR(50), по умолчанию NULL
  (Заголовок)
- **comment**: TEXT, по умолчанию NULL
  (Текст комментария)
- **date**: DATETIME, по умолчанию NULL (Дата и время создания записи)
- **likes**: INT (Количество лайков на комментарии)

## Алгоритмы

- **Алгоритм создания комментария**

Пользователь может ввести только заголовок и комментарий. Так как лента комментариев анонимная, то у всех пользователей автоматически добавляется имя: anonymous. Также каждому комментарию присваивается дата и время, когда он был отправлен, и уникальный id, который не выводится на страницу, но хранится в БД.

![comm.png](screens/comm.png)


- **Алгоритм реакций на комментарии**

Пользователь может отреагировать на комментарий (поставить лайк). Нажимая на кнопку лайка количество выбранных реакций увеличивается.

![react.png](screens/like.png)

- **Алгоритмы изменения и удаления**

Пользователь может изменить или удалить комментарий, для этого существуют 2 кнопки:

![buttons.png](screens/buttons.png)

При нажатии на первую появляется окно, где можно изменить информацию в комментарии:

![buttons.png](screens/button1.png)

При нажатии на вторую появляется окно, где можно удалить комментарий:

![buttons.png](screens/button2.png)
## Программный код, реализующий систему

#### Реализация добавления комментария в БД
```php
$name = $_POST['name'];
$comment = $_POST['comment'];
$pos = $_POST['pos'];
$date = date("Y-m-d G:i:s", time() + 0);

// Create
if (isset($_POST['submit'])) {
	$sql = ("INSERT INTO `users`(`name`, `comment`, `date`, `likes`) VALUES(?,?,?,0)");
	$query = $pdo->prepare($sql);
	$query->execute([$name, $comment, $date]);
	$success = '<div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>Данные успешно отправлены!</strong> Вы можете закрыть это сообщение.
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>';
    header('Location: '. $_SERVER['HTTP_REFERER']);
}
```
###  Реализация вывода комментариев с лайками на сайт
```php
$sql = $pdo->prepare("SELECT * FROM `users` ORDER BY `date` DESC LIMIT 100");
$sql->execute();
$result = $sql->fetchAll();
```
### Реализация редактирования и удаления комментариев
```php
$edit_name = $_POST['edit_name'];
$edit_comment = $_POST['edit_comment'];
$edit_pos = $_POST['edit_pos'];
$edit_date = $_POST['edit_date'];
$get_id = $_GET['id'];

// EDIT
if (isset($_POST['edit-submit'])) {
	$sqll = "UPDATE `users` SET (`name`=?, `comment`=?, `date`=?) WHERE `id`=?";
	$querys = $pdo->prepare($sqll);
	$querys->execute([$edit_name, $edit_comment, $edit_date, $get_id]);
	header('Location: '. $_SERVER['HTTP_REFERER']);
}

// DELETE
if (isset($_POST['delete_submit'])) {
	$sql = "DELETE FROM users WHERE id=?";
	$query = $pdo->prepare($sql);
	$query->execute([$get_id]);
	header('Location: '. $_SERVER['HTTP_REFERER']);
}
```
###  Реализация реагирования на комментарий (лайки)
```php
// REACT
if (isset($_POST['like-submit'])) {
    $con = mysqli_connect("127.0.0.1","root", "root", "crud");
    $sql1 = "SELECT * FROM `users` WHERE `id`='$get_id'";
    $result1 = mysqli_query($con, $sql1);
    $row = mysqli_fetch_assoc($result1);
    $likes = $row['likes'] + 1;

    $sql2 = "UPDATE `users` SET `likes`=? WHERE `id`=?";
    $query2 = $pdo->prepare($sql2);
    $query2->execute([$likes, $get_id]);
    header('Location: '. $_SERVER['HTTP_REFERER']);
}
```