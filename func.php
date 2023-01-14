<?php
include 'config.php';
date_default_timezone_set('Europe/Moscow');

$name = $_POST['name'];
$msg = $_POST['msg'];
$title = $_POST['title'];
$date = date("Y-m-d G:i:s", time() + 0);


// Create
if (isset($_POST['submit'])) {
    $ttl = $_GET['open'];
	$sql = ("INSERT INTO `$ttl` (`name`, `msg`, `date`) VALUES(?,?,?)");
	$query = $pdo->prepare($sql);
	$query->execute([$name, $msg, $date]);
    unset($_POST['submit']);
}

// Read
$q = $pdo->prepare("SELECT * FROM `chats`");
$q->execute();
$result = $q->fetchAll();

//$edit_name = $_POST['edit_name'];
//$edit_comment = $_POST['edit_comment'];
//$edit_pos = $_POST['edit_pos'];
//$edit_date = $_POST['edit_date'];
$get_id = $_GET['id'];

//// EDIT
//if (isset($_POST['edit-submit'])) {
//	$sqll = "UPDATE `users` SET (`name`=?, `comment`=?, `date`=?) WHERE `id`=?";
//	$querys = $pdo->prepare($sqll);
//	$querys->execute([$edit_name, $edit_comment, $edit_date, $get_id]);
//	header('Location: '. $_SERVER['HTTP_REFERER']);
//}
//
//// DELETE
//if (isset($_POST['delete_submit'])) {
//	$sql = "DELETE FROM users WHERE id=?";
//	$query = $pdo->prepare($sql);
//	$query->execute([$get_id]);
//	header('Location: '. $_SERVER['HTTP_REFERER']);
//}
//
//// REACT
//if (isset($_POST['like-submit'])) {
//    $con = mysqli_connect("127.0.0.1","root", "root", "crud");
//    $sql1 = "SELECT * FROM `users` WHERE `id`='$get_id'";
//    $result1 = mysqli_query($con, $sql1);
//    $row = mysqli_fetch_assoc($result1);
//    $likes = $row['likes'] + 1;
//
//    $sql2 = "UPDATE `users` SET `likes`=? WHERE `id`=?";
//    $query2 = $pdo->prepare($sql2);
//    $query2->execute([$likes, $get_id]);
//    header('Location: '. $_SERVER['HTTP_REFERER']);
//}




if (isset($_POST['submitNewChat'])) {
    $con = mysqli_connect("127.0.0.1","root", "root", "chat");
    $title = $_POST['title'];
    $sql = "CREATE TABLE `$title` (`id` INT NOT NULL AUTO_INCREMENT , `name` VARCHAR(50) NOT NULL , `msg` TEXT NOT NULL , `date` DATETIME NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB";
    mysqli_query($con, $sql);

    $sql2 = "INSERT INTO `chats`(`title`) VALUES (?)";
    $query2 = $pdo->prepare($sql2);
    $query2->execute([$title]);
    header('Location: '. $_SERVER['HTTP_REFERER']);
}
