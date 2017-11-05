<?php

$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'shopcart_table';

$conn = mysqli_connect($servername, $username, $password, $dbname);

if(!$conn){
    echo 'DB Connection Error '.mysqli_connect_error();
}
