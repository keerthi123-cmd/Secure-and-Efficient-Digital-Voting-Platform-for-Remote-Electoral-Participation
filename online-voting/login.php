<?php
session_start();
include("db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, password,has_voted FROM users WHERE voter_id = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($id,$hashed,$voted);
    $stmt->fetch();
    if ($id && password_verify($password, $hashed)) {
        if ($voted == 1) {
            echo "❌ You have already casted your vote. Thank you!";
            echo '<a href="index.html" class="btn btn-danger">Home</a>';
        }
        else{
        $_SESSION['user_id'] = $id;
        header("Location: home.php");   
        }
    } else {
        echo "Login failed    <a href='login.html'>Try Again</a>";
    }
}
?>
