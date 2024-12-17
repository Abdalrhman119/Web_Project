<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['user_email'];
    $password = $_POST['user_password'];

    $pdo = new PDO('mysql:host=localhost;dbname=store_db', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->prepare("SELECT * FROM clients WHERE Email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $signup_message = "This email is already in use!";
    } else {
        $stmt = $pdo->prepare("INSERT INTO clients (Email, password) VALUES (?, ?)");
        $stmt->execute([$email, $password]);
        $signup_message = "Account created successfully! You can now log in.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="StyleLogin.css">
</head>
<body>
    <form action="signup.php" method="post">
        <img src="img/pngegg.png" alt="Profile Icon" class="form-image">
        <br>
        Email: <input type="email" name="user_email" required>
        <br>
        Password: <input type="password" name="user_password" required>
        <br>
        <input type="submit" name="submit" value="Sign Up">
        <br>
        <?php if (isset($signup_message)) { echo "<p>$signup_message</p>"; } ?>
        <br>
        <a href="login.php">Already have an account? Login</a>
    </form>
</body>
</html>
