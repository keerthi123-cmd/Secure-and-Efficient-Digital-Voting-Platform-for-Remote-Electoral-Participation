<?php
include("db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname=$_POST['firstname'];
    $lastname=$_POST['lastname'];
    $email=$_POST['email'];
    $phone = $_POST['phone'];
    $aadhar = $_POST['aadhar'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $username = $_POST['voterId'];
    $state = $_POST['state'];
    $district = $_POST['district'];
    $ward = $_POST['ward'];

    $imgName = $_FILES['photo']['name'];
    $imgTmp = $_FILES['photo']['tmp_name'];
    $imgPath = "uploads/" . time() . "_" . basename($imgName);
    move_uploaded_file($imgTmp, $imgPath);

    $stmt = $conn->prepare("INSERT INTO users (first_name,last_name,email,phone_number,aadhar_number,voter_id,state,district,ward_no,password,image_path)
     VALUES (?,?,?,?,?,?,?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssssss",$firstname,$lastname,$email,$phone,$aadhar,$username,$state,$district,$ward,$password,$imgPath);
    $stmt->execute();

    echo "Registered successfully. <a href='login.html'>Login</a>";
}
?>
