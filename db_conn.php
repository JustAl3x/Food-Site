<?php

$sname = "localhost";
$uname = "root";
$password = "";

$db_name = "test_db";

$conn = mysqli_connect($sname, $uname, $password ,$db_name);
if(!$conn){
    echo "Connection Failed";
}

function getCategories(){
    $mysqli = mysqli_connect();
    $result = $mysqli ->query("SELECT DISTINCT category FROM products");
    while($row = $result -> fetch_assoc()){
        $categories[] = $row;
    }
    return $categories;
}