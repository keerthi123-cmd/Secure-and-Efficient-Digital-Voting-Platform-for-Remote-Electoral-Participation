<?php
include("session.php");
include("db.php");

function encryptData($data) {
    $key = hash('sha256', 'my_secret_key');
    $iv = substr(hash('sha256', 'my_secret_iv'), 0, 16);

    return openssl_encrypt($data, 'AES-256-CBC', $key, 0, $iv);
}
function decryptData($encrypted) {
    $key = hash('sha256', 'my_secret_key');
    $iv = substr(hash('sha256', 'my_secret_iv'), 0, 16);

    return openssl_decrypt($encrypted, 'AES-256-CBC', $key, 0, $iv);
}

$user_id = $_SESSION['user_id'];
$party = $_SESSION['party'];
$stored_img = $_POST['stored_img'];

// Save uploaded live image
$liveImgName = $_FILES['live_img']['name'];
$liveTmp = $_FILES['live_img']['tmp_name'];
$livePath = "uploads/" . time() . "_" . basename($liveImgName);
move_uploaded_file($liveTmp, $livePath);


// Check file paths
$img1_path = realpath($stored_img);
$img2_path = realpath($livePath);

if (!$img1_path || !$img2_path) {
    die("❌ Error: One or both image paths are invalid.");
}

// Send both images to Python API
$apiURL = "http://localhost:5000/verify";

$curl = curl_init();
$postFields = [
    'img1' => new CURLFile(realpath($stored_img)),
    'img2' => new CURLFile(realpath($livePath))
];

curl_setopt_array($curl, [
    CURLOPT_URL => $apiURL,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => $postFields
]);

$response = curl_exec($curl);
curl_close($curl);

$data = json_decode($response, true);
echo '<div class="container mt-5 text-center">';
if ($data['verified']) {
    // Insert vote

    $stmt = $conn->prepare("INSERT INTO votes (user_id, party) VALUES (?, ?)");
    $encrypted_user_id = encryptData($user_id);
    $stmt->bind_param("ss", $encrypted_user_id, $party);

    $stmt->execute();

    $update = $conn->prepare("UPDATE users SET has_voted = 1 WHERE id = ?");
    $update->bind_param("i", $user_id);
    $update->execute();
    echo '<div class="alert alert-success" role="alert" style="font-size: 18px; padding: 30px; border-radius: 10px;">';
    echo "✅ <strong>Face Verified!</strong> Your vote has been recorded.";
    echo '</div>';
    echo '<a href="logout.php" class="btn btn-danger btn-lg" style="font-size: 16px; padding: 12px 30px; border-radius: 50px; text-decoration: none;">Logout</a>';
} else {
    echo '<div class="alert alert-danger" role="alert" style="font-size: 18px; padding: 30px; border-radius: 10px;">';
    echo "❌ <strong>Face verification failed.</strong> Please try again.";
    echo '</div>';
    echo '<a href="form-vote.php" class="btn btn-warning btn-lg" style="font-size: 16px; padding: 12px 30px; border-radius: 50px; text-decoration: none;">Retry</a>';
}
echo '</div>';
?>
