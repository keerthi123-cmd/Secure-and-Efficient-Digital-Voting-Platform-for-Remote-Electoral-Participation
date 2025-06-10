<?php
include("session.php");
include("db.php");

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>e-Voting</title>
    <link rel="stylesheet" href="votinghome.css">
    <style>
        .btn-log{
        background-color: #f31313;
        border: none;
        color: rgb(255, 255, 255);
        padding: 10px 25px;
        border-radius: 5px;
        cursor: pointer;
        font-size: 14px;
}
.auth-buttons .btn-log:hover{
    background-color: #c84545;  
}
    </style>
</head>
<body>

    <div class="header">
        <div class="title">
            <h1>e-Voting</h1>
        </div>
        <div class="auth-buttons">
           
            
            <form action="verify_credentials.php">
            <button type="submit" class="btn-signup">VOTE NOW</button>
            </form>
            <form action="logout.php"  method="POST">

    			<button type="submit" class="btn-log">Log Out</button>

			</form>
            
            
        </div>
    </div>
	
    <div class="main-content">
        <div class="quote-section">

            <h2>The future depends on what you do today.</h2>
            <p>~ Mahatma Gandhi</p>
        </div>
        <div class="im1">
            <img src="https://media.istockphoto.com/id/1309409153/vector/conceptual-illustration-of-political-parties-campaigning-for-vote-in-front-of-a-huge-hand.jpg?s=612x612&w=is&k=20&c=iISRKLSw5dzhSBz-z5Y0h6ZZzmhmMG5c_RSlh2f6Nsk=" alt="Voting Illustration">
        </div>
    </div>


</body>
</html>
