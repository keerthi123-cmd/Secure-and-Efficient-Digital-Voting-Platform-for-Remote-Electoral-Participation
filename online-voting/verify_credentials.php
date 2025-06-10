<?php
include("session.php");
include("db.php");

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $aadhar = $_POST['aadhar'];
    $voter_id = $_POST['voter_id'];
    $stmt = $conn->prepare("SELECT id FROM users WHERE aadhar_number = ? AND voter_id = ?");
    $stmt->bind_param("ss", $aadhar, $voter_id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 1) {
        // Redirect to next step
        header("Location: form-vote.php");
        exit;
    } else {
        $message = "❌ Invalid Aadhar Number or Voter ID.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Voter Verification</title>
    <style>
        body {
            background: url('https://img.freepik.com/premium-vector/vote-ballot-box-people-putting-pepper-vote-into-box-election-concept-democracy-freedom-speech-justice-voting-opinion-referendum-poll-choice-event-vector-illustration_98702-1378.jpg?w=1060') no-repeat center center/cover;
   			background-size: cover;
            font-family: Arial, sans-serif;
		    margin: 0;
		    padding: 0;
		    position: relative;
            display: flex;
            height: 100vh;
            justify-content: center;
            align-items: center;
            
        }
        body::before {
		    content: "";
		    position: fixed;
		    top: 0;
		    left: 0;
		    width: 100%;
		    height: 100%;
		    background: url('https://img.freepik.com/premium-vector/vote-ballot-box-people-putting-pepper-vote-into-box-election-concept-democracy-freedom-speech-justice-voting-opinion-referendum-poll-choice-event-vector-illustration_98702-1378.jpg?w=1060') no-repeat center center/cover;
		    background-size: cover;
		    filter: blur(8px); /* Adjust blur intensity */
		    z-index: -1;
		}
        .container {
            background: rgba(210, 210, 210, 0.7);
            padding: 30px 40px;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            width: 350px;
            text-align: center;
        }
        h2 {
            margin-bottom: 20px;
            color: #333;
        }
        input[type="text"] {
            width: 90%;
            padding: 10px;
            margin: 10px 0 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
        }
        button {
            background: #28a745;
            color: white;
            padding: 10px 25px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background: #218838;
        }
        .message {
            color: red;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Verify Your Identity</h2>

    <?php if ($message): ?>
        <div class="message"><?php echo $message; ?></div>
    <?php endif; ?>

    <form method="POST">
        <input type="text" name="aadhar" placeholder="Aadhar Number" required />
        <input type="text" name="voter_id" placeholder="Voter ID" required />
        <br>
        <button type="submit">Verify</button>
    </form>
</div>

</body>
</html>
