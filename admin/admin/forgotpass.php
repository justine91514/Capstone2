<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
</head>
<body>
    <h2>Forgot Password</h2>
    <form method="post" action="send-password-reset.php" >
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required>
        <button type="submit" name="forgotpass_btn">Reset Password</button>
    </form>
</body>
</html>
