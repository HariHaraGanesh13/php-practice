<?php
$host = "localhost";
$user = "Harry";
$pass = "harry123";
$db = "product_db";

try{
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e){
    die("Connection failed");
}