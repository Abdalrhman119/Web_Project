<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cart_item_id = $_POST['cart_item_id'];
    $user_email = isset($_SESSION['user_email']) ? $_SESSION['user_email'] : null;

    if ($user_email && $cart_item_id) {
        $pdo = new PDO('mysql:host=localhost;dbname=store_db', 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->prepare("DELETE FROM cart_items WHERE id = ? AND user_email = ?");
        $stmt->execute([$cart_item_id, $user_email]);

        header('Location: cart.php');
        exit();
    }
}
?>
