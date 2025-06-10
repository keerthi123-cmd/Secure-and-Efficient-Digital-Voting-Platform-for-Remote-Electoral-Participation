<?php
include("session.php");
include("db.php");

// Fetch all parties
$query = "SELECT * FROM parties";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Election Voting</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: url('https://img.freepik.com/premium-vector/vote-ballot-box-people-putting-pepper-vote-into-box-election-concept-democracy-freedom-speech-justice-voting-opinion-referendum-poll-choice-event-vector-illustration_98702-1378.jpg?w=1060') no-repeat center center/cover;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
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
            filter: blur(8px);
            z-index: -1;
        }

        .party-card {
            border: 2px solid #ddd;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            background-color: white;
            transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
            width: 200px;
        }

        .party-card:hover {
            transform: scale(1.05);
            box-shadow: 4px 4px 15px rgba(0, 0, 0, 0.2);
        }

        .party-logo {
            width: 100px;
            height: 100px;
            object-fit: cover;
            margin-bottom: 10px;
        }

        .party-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }

        h2 {
            color: white;
            text-shadow: 2px 2px 5px black;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Choose Your Party</h2>
        <div class="party-container">
            <?php
            $colors = ['bg-color-1', 'bg-color-2', 'bg-color-3', 'bg-color-4', 'bg-color-5'];
            $i = 0;

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $partyName = htmlspecialchars($row['name']);
                    $partyLogo = htmlspecialchars($row['image_path']);
                    $colorClass = $colors[$i % count($colors)];
                    echo '
                    <form action="vote.php" method="post" enctype="multipart/form-data">
                        <div class="party-card ' . $colorClass . '">
                            <img src="' . $partyLogo . '" alt="Party Logo" class="party-logo">
                            <h4>' . $partyName . '</h4>
                            <input type="hidden" name="party" value="' . $partyName . '">
                            <button type="submit" class="btn btn-primary">Vote</button>
                        </div>
                    </form>';
                    $i++;
                }
            } else {
                echo '<p class="text-white text-center">No parties available to vote.</p>';
            }
            ?>
        </div>
    </div>
</body>

</html>
