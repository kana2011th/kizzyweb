<?php
require '../config.php';
session_start();

if ($_SESSION['id'] == '') die('Login');
if ($_POST['id'] == '') die('Parameter');
$create = $pdo->prepare("DELETE FROM `gift` WHERE `id` = ? and `reciver` = ?");
$query = $create->execute(array($_POST['id'], $_SESSION['id']));
if (!$query) die('Error');
die('Success');
