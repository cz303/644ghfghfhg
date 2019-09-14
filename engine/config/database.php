<?php
include ("table.php");
$config = array(
	//База 
	'host' => 'localhost',
	'user' => 'root',
	'pass' => '',
	'db' => 'ds12' );

$connect = mysqli_connect("$config[host]", "$config[user]", "$config[pass]", "$config[db]");
if (mysqli_connect_errno()) {
    printf("Сайт временно не доступен!", mysqli_connect_error());
    exit();
}
