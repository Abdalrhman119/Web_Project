<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_email = $_POST['user_email'];
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    if ($user_email && $product_id && $quantity) {
        $pdo = new PDO('mysql:host=localhost;dbname=store_db', 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->prepare("SELECT * FROM cart_items WHERE user_email = ? AND product_id = ?");
        $stmt->execute([$user_email, $product_id]);
        $cart_item = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($cart_item) {
            $new_quantity = $cart_item['quantity'] + $quantity;
            $update_stmt = $pdo->prepare("UPDATE cart_items SET quantity = ? WHERE id = ?");
            $update_stmt->execute([$new_quantity, $cart_item['id']]);
        } else {
            $stmt = $pdo->prepare("INSERT INTO cart_items (user_email, product_id, quantity) VALUES (?, ?, ?)");
            $stmt->execute([$user_email, $product_id, $quantity]);
        }
        header('Location: cart.php');
        exit();
    }
}
?>
