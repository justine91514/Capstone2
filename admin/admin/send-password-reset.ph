<?php
$email = $_POST["email"];
$token = bin2hex(random_bytes(16));
$token_hash = hash("sha256", $token);
$expiry = date("Y-m-d H:i:s", time() + 60 * 30);

// Correct the require statement
$mysqli = require __DIR__ . "/dbconfig.php";

$sql = "UPDATE register
        SET reset_token_hash = ?,
        reset_token_expires_at = ?
        WHERE email = ?";
$stmt = $mysqli->prepare($sql);

if (!$stmt) {
    die("Error in SQL statement: " . $mysqli->error);
}

$stmt->bind_param("sss", $token_hash, $expiry, $email);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo "Password reset token updated successfully";
} else {
    echo "Error updating password reset token";
}

$stmt->close();
$mysqli->close();
?>
