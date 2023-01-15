<?php
include 'config.php';
date_default_timezone_set('Europe/Moscow');

$name = $_POST['name'];
$msg = $_POST['msg'];
$title = $_POST['title'];
$date = date("Y-m-d G:i:s", time() + 0);
$get_id = $_GET['id'];

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
