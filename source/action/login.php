<?php
if ($_POST['username'] == '' && $_POST['password'] == '') die('Parameter');
if (!(preg_match('/^[a-zA-Z0-9_\s]+$/', $_POST['username']))) die('Error');
require '../config.php';
session_start();
if ($_SESSION['id'] != '') die('Login');
$query = $pdo->prepare("SELECT `id`, `username`, `password`, `point`, `isadmin` FROM `authme` WHERE `username` = ?");
$query->execute(array($_POST['username']));
$data = $query->fetch(PDO::FETCH_ASSOC);
$salt = explode('$', $data['password']);
$salt = $salt[2];
$hash = '$SHA$' . $salt . '$' . hash('sha256', hash('sha256', $_POST['password']) . $salt);
if ($data['password'] != $hash)
  die('Error');
$_SESSION['id'] = $data['id'];
$_SESSION['username'] = $data['username'];
$_SESSION['point'] = $data['point'];
$_SESSION['isadmin'] = $data['isadmin'];
$_SESSION['update'] = time();
die('Logged');
