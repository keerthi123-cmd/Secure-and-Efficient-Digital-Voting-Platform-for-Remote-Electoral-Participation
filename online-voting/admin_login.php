<?php
session_start();
include("db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT admin_id,password FROM admins WHERE username = ?");

    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($id,$hashed);
    $stmt->fetch();
    if ( password_verify($password, $hashed)) {
        $_SESSION['admin_id']=$id;
        header("Location: admin_dashboard.php");
        
    } else {
        echo "Login failed";
    }
}
?>
