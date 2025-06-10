<?php
include("db.php");

$sql = "SELECT party, COUNT(*) AS vote_count FROM votes GROUP BY party order by vote_count desc";
$result = $conn->query($sql);

$parties = [];
$votes = [];

while ($row = $result->fetch_assoc()) {
    $parties[] = $row['party'];
    $votes[] = $row['vote_count'];
}

$winnerQuery = "SELECT party, COUNT(*) AS vote_count FROM votes GROUP BY party ORDER BY vote_count DESC LIMIT 1";
$winnerResult = $conn->query($winnerQuery);
$winningParty = null;
$winningVotes = 0;

if ($winnerResult && $winnerResult->num_rows > 0) {
    $winnerRow = $winnerResult->fetch_assoc();
    $winningParty = $winnerRow['party'];
    $winningVotes = $winnerRow['vote_count'];
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Voting Summary</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            background: url('https://img.freepik.com/premium-vector/vote-ballot-box-people-putting-pepper-vote-into-box-election-concept-democracy-freedom-speech-justice-voting-opinion-referendum-poll-choice-event-vector-illustration_98702-1378.jpg?w=1060') no-repeat center center/cover;
            background-size: cover;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
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
            background: rgba(255, 255, 255, 0.9);
            margin: 50px auto;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            width: 95%;
            max-width: 900px;
        }

        .table th, .table td {
            vertical-align: middle;
        }

        canvas {
            max-width: 100%;
        }

        .btn-secondary {
            border-radius: 6px;
        }
    </style>
</head>
<body>
<div class="content-wrapper">
    <h2 class="mb-4 text-center">📊 Voting Summary</h2>

    <?php if ($winningParty): ?>
    <div class="alert alert-success text-center fw-bold fs-5">
        🏆 <strong>Current Leading Party:</strong> <?= htmlspecialchars($winningParty) ?> with <?= $winningVotes ?> votes
    </div>
<?php else: ?>
    <div class="alert alert-warning text-center">
        No votes have been recorded yet.
    </div>
<?php endif; ?>
    <!-- Vote Count Table -->
    <table class="table table-bordered text-center bg-white">
        <thead class="thead-dark">
        <tr>
            <th>Party</th>
            <th>Vote Count</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($parties as $index => $party): ?>
            <tr>
                <td><?= htmlspecialchars($party) ?></td>
                <td><?= $votes[$index] ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Chart -->
    <div class="my-4" style="height: 400px;">
        <canvas id="voteChart"></canvas>
    </div>

    <div class="text-center mt-4">
        <a href="admin_dashboard.php" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Dashboard
        </a>
    </div>
</div>

<script>
    const ctx = document.getElementById('voteChart').getContext('2d');
    const voteChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?= json_encode($parties) ?>,
            datasets: [{
                label: 'Vote Count',
                data: <?= json_encode($votes) ?>,
                backgroundColor: [
                    '#FF6384', '#36A2EB', '#FFCE56', '#66BB6A', '#BA68C8', '#FFA726',
                    '#4BC0C0', '#9966FF', '#FF9F40', '#8AC24A', '#607D8B', '#E91E63'
                ],
                borderColor: [
                    '#FF6384', '#36A2EB', '#FFCE56', '#66BB6A', '#BA68C8', '#FFA726',
                    '#4BC0C0', '#9966FF', '#FF9F40', '#8AC24A', '#607D8B', '#E91E63'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Number of Votes'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Political Parties'
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                },
                title: {
                    display: true,
                    text: 'Vote Distribution by Party',
                    font: {
                        size: 16
                    }
                }
            }
        }
    });
</script>
</body>
</html>
