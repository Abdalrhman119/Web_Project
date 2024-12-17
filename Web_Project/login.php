<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['user_email'];
    $password = $_POST['user_password'];

    $pdo = new PDO('mysql:host=localhost;dbname=store_db', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->prepare("SELECT * FROM clients WHERE email = ? AND password = ?");
    $stmt->execute([$email, $password]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        session_start();
        $_SESSION['user_email'] = $email;
        header('Location: home.php');
    } else {
        $login_message = "Invalid credentials!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="StyleLogin.css">
</head>
<body>
    <form action="login.php" method="post">
        <img src="img/pngegg.png" alt="Profile Icon" class="form-image">
        <br>
        Email: <input type="email" name="user_email" required>
        <br>
        Password: <input type="password" name="user_password" required>
        <br>
        <input type="submit" name="submit" value="Login">
        <br>
        <?php if (isset($login_message)) { echo "<p>$login_message</p>"; } ?>
        <br>
        <p>Don't have an account? <a href="signup.php">Sign up</a></p>
    </form>
</body>
</html>
