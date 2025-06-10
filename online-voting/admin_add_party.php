<?php // ensure only admin has access
include("admin_session.php");
include("db.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $partyName = $_POST['party_name'];
    $imagePath = '';

    if (isset($_FILES['party_img']) && $_FILES['party_img']['error'] === 0) {
        $targetDir = "party_logos/";
        if (!is_dir($targetDir)) mkdir($targetDir);

        $imageName = basename($_FILES["party_img"]["name"]);
        $targetFile = $targetDir . time() . "_" . $imageName;

        if (move_uploaded_file($_FILES["party_img"]["tmp_name"], $targetFile)) {
            $imagePath = $targetFile;
        }
    }

    $stmt = $conn->prepare("INSERT INTO parties (name, image_path) VALUES (?, ?)");
    $stmt->bind_param("ss", $partyName, $imagePath);
    $stmt->execute();
    $stmt->close();

    echo "<script>alert('Party added successfully!'); window.location='admin_add_party.php';</script>";
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Add Party</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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

    .form-container {
      background: rgba(255, 255, 255, 0.85);
      padding: 40px;
      border-radius: 16px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
      width: 90%;
      max-width: 500px;
    }

    h2 {
      color: #333;
      text-align: center;
      margin-bottom: 30px;
    }

    .btn-primary {
      background-color: #007bff;
      border: none;
    }

    .btn-primary:hover {
      background-color: #0056b3;
    }

    .btn-secondary {
      margin-left: 10px;
    }
  </style>
</head>
<body>

<div class="form-container">
  <h2>Add New Party</h2>
  <form method="post" enctype="multipart/form-data">
    <div class="form-group">
      <label>Party Name:</label>
      <input type="text" name="party_name" class="form-control" required>
    </div>

    <div class="form-group">
      <label>Party Logo:</label>
      <input type="file" name="party_img" class="form-control" required>
    </div>

    <button type="submit" class="btn btn-primary">Add Party</button>
    <a href="admin_dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
  </form>
</div>

</body>
</html>
