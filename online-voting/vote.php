<?php
include("session.php");
include("db.php");
$user_id = $_SESSION['user_id'];
$_SESSION['party']=$_POST['party'];
$stmt = $conn->prepare("SELECT image_path FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($storedImage);
$stmt->fetch();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Face Verification</title>
    <style>
        body {
            background: url('https://img.freepik.com/premium-vector/vote-ballot-box-people-putting-pepper-vote-into-box-election-concept-democracy-freedom-speech-justice-voting-opinion-referendum-poll-choice-event-vector-illustration_98702-1378.jpg?w=1060') no-repeat center center/cover;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
        }

        body::before {
            content: "";
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: inherit;
            background-size: cover;
            filter: blur(8px);
            z-index: -1;
        }

        .form-container {
            background: rgba(210, 210, 210, 0.7);
            padding: 30px 40px;
            border-radius: 12px;
            text-align: center;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
            color: #fff;
        }

        .form-container h2 {
            margin-bottom: 20px;
        }

        input[type="file"] {
            margin: 15px 0;
            padding: 8px;
            background-color:rgb(81, 76, 76);
            border-radius: 5px;
        }

        button {
            padding: 10px 25px;
            font-size: 16px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
        }

        button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Upload Your Image</h2>
        <p>(Make sure your face is well-lit and visible)</p>
        <form action="verify_vote.php" method="post" enctype="multipart/form-data">
            <input type="file" name="live_img" accept="image/*" required><br>
            <input type="hidden" name="stored_img" value="<?= $storedImage ?>" />
            <button type="submit">Submit</button>
        </form>
    </div>
</body>
</html>
