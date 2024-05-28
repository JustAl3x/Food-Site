<?php
include "db_conn.php";

if(isset($_POST['name'])  && isset($_POST['uname']) && isset($_POST['password'])) {
    function validate($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
}

$name = validate($_POST['name']);
$uname = validate($_POST['uname']);
$pass = validate($_POST['password']);

if(empty($name)){
    header("Location: index.php?error=Name is required");
    exit();
} 
else if(empty($uname)){
header("Location: index.php?error=Username is required");
exit();
}
else if(empty($pass)){
    header("Location: index.php?error=Password is required");
    exit;
}

$sql = "INSERT INTO users (name, user_name, password) VALUES ('$name', '$uname', '$pass')";

if (mysqli_query($conn, $sql)) {
    echo "New user registered successfully!";
    session_start();
    $_SESSION['user_name'] = $uname;
    $_SESSION['name'] = $name;
} else {
    header("Location: register.php");
    exit();
}

$sql = "SELECT * FROM users WHERE user_name='$uname' AND password='$pass'";

$result = mysqli_query($conn, $sql);

if(mysqli_num_rows($result)=== 1 ) {
    $row = mysqli_fetch_assoc($result);
    $_SESSION['id'] = $row['id'];
    header("location: home.php");
    exit();
}
else{
    header("Location: register.php");
    exit();
}

