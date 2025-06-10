<?php
include("admin_session.php");
include("db.php");

// Delete party if requested
if (isset($_GET['delete'])) {
    $party_id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM parties WHERE id = ?");
    $stmt->bind_param("i", $party_id);
    $stmt->execute();
    header("Location: manage_parties.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Parties</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background: url('https://img.freepik.com/premium-vector/vote-ballot-box-people-putting-pepper-vote-into-box-election-concept-democracy-freedom-speech-justice-voting-opinion-referendum-poll-choice-event-vector-illustration_98702-1378.jpg?w=1060') no-repeat center center/cover;
            background-size: cover;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            height: 100vh;
        }

        body::before {
            content: "";
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            background: url('https://img.freepik.com/premium-vector/vote-ballot-box-people-putting-pepper-vote-into-box-election-concept-democracy-freedom-speech-justice-voting-opinion-referendum-poll-choice-event-vector-illustration_98702-1378.jpg?w=1060') no-repeat center center/cover;
            filter: blur(8px);
            z-index: -1;
        }

        .content-wrapper {
            background: rgba(255, 255, 255, 0.70);
            margin: 40px auto;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            width: 95%;
            max-width: 900px;
        }

        .party-img {
            width: 60px;
            height: 60px;
            object-fit: contain;
        }

        .table th, .table td {
            vertical-align: middle;
            text-align: center;
        }

        .btn-success, .btn-danger, .btn-secondary {
            border-radius: 6px;
        }
    </style>
</head>
<body>

<div class="content-wrapper">
    <h2 class="mb-4 text-center">   Manage Parties</h2>

    <div class="text-right mb-3">
        <a href="admin_add_party.php" class="btn btn-success">
            <i class="fas fa-plus"></i> Add New Party
        </a>
    </div>

    <table class="table table-bordered table-hover bg-white">
        <thead class="thead-dark">
            <tr>
                <th>ID</th>
                <th>Party Name</th>
                <th>Party Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $result = $conn->query("SELECT * FROM parties");
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>{$row['id']}</td>";
                echo "<td>{$row['name']}</td>";
                echo "<td><img src='{$row['image_path']}' class='party-img' alt='Party Logo'></td>";
                echo "<td>
                        <a href='manage_parties.php?delete={$row['id']}' class='btn btn-danger btn-sm' onclick=\"return confirm('Are you sure you want to delete this party?');\">
                            <i class='fas fa-trash'></i> Delete
                        </a>
                      </td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>

    <div class="text-center mt-4">
        <a href="admin_dashboard.php" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Dashboard
        </a>
    </div>
</div>

</body>
</html>
