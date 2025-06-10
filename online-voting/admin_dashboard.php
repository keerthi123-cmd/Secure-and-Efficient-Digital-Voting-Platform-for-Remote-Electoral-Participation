<?php
include("admin_session.php");
include("db.php");
?>

<!DOCTYPE html>
<html>
<head>
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <style>
    body {
      margin: 0;
      padding: 0;
      font-family: Arial, sans-serif;
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      background: url('https://img.freepik.com/premium-vector/vote-ballot-box-people-putting-pepper-vote-into-box-election-concept-democracy-freedom-speech-justice-voting-opinion-referendum-poll-choice-event-vector-illustration_98702-1378.jpg?w=1060') no-repeat center center/cover;
    }

    body::before {
      content: "";
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: url('https://img.freepik.com/premium-vector/vote-ballot-box-people-putting-pepper-vote-into-box-election-concept-democracy-freedom-speech-justice-voting-opinion-referendum-poll-choice-event-vector-illustration_98702-1378.jpg?w=1060') no-repeat center center/cover;
      filter: blur(8px);
      z-index: -1;
    }

    .dashboard-container {
      background: rgba(255, 255, 255, 0.8);
      padding: 40px;
      border-radius: 16px;
      box-shadow: 0 10px 25px rgba(0,0,0,0.15);
      text-align: center;
      width: 90%;
      max-width: 1000px;
    }

    h2 {
      color: #333;
      margin-bottom: 30px;
    }

    .card {
      transition: transform 0.2s ease;
      border-radius: 20px;
      background-color: #fff;
    }

    .card:hover {
      transform: scale(1.03);
    }

    .icon {
      font-size: 2.5rem;
      margin-bottom: 10px;
      color: #007bff;
    }

    .btn-logout {
      background-color: #f31313;
      border: none;
      color: white;
      padding: 10px 25px;
      border-radius: 8px;
      cursor: pointer;
      font-size: 16px;
      margin-top: 20px;
    }

    .btn-logout:hover {
      background-color: #c84545;
    }

    a.text-decoration-none {
      text-decoration: none !important;
    }
  </style>
</head>
<body>

<div class="dashboard-container">
  <h2>Admin Dashboard</h2>

  <div class="row">
    <div class="col-md-4 mb-4">
      <a href="admin_add_party.php" class="text-decoration-none text-dark">
        <div class="card text-center shadow-sm p-3">
          <i class="fas fa-plus-circle icon"></i>
          <h5>Add Party</h5>
        </div>
      </a>
    </div>

    <div class="col-md-4 mb-4">
      <a href="manage_parties.php" class="text-decoration-none text-dark">
        <div class="card text-center shadow-sm p-3">
          <i class="fas fa-list icon"></i>
          <h5>Manage Parties</h5>
        </div>
      </a>
    </div>

    <div class="col-md-4 mb-4">
      <a href="view_votes.php" class="text-decoration-none text-dark">
        <div class="card text-center shadow-sm p-3">
          <i class="fas fa-chart-bar icon"></i>
          <h5>View Votes</h5>
        </div>
      </a>
    </div>
  </div>

  <a href="logout.php" class="btn-logout">Logout</a>
</div>

</body>
</html>
