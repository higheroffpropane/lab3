<?php

try {
	$pdo = new PDO('mysql:dbname=chat; host=127.0.0.1', 'root', 'root');
} catch (PDOException $e) {
	die($e->getMessage());
}