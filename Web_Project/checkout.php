<?php
session_start();

$user_email = isset($_SESSION['user_email']) ? $_SESSION['user_email'] : null;

if (!$user_email) {
    echo "You need to log in to proceed with checkout.";
    exit;
}

$pdo = new PDO('mysql:host=localhost;dbname=store_db', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$stmt = $pdo->prepare("SELECT ci.id, p.name, p.price, ci.quantity FROM cart_items ci JOIN products p ON ci.product_id = p.id WHERE ci.user_email = ?");
$stmt->execute([$user_email]);
$cart_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (count($cart_items) == 0) {
    echo "Your cart is empty.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="stylecheckout.css">
</head>
<body>
    <div class="container">
        <h1>Checkout</h1>
        <table class="cart-table">
            <tr>
                <th>Product Name</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total</th>
            </tr>
            <?php
            $total_price = 0;
            foreach ($cart_items as $item): 
                $total_price += $item['price'] * $item['quantity'];
            ?>
                <tr>
                    <td><?php echo $item['name']; ?></td>
                    <td><?php echo $item['price']; ?> E.G</td>
                    <td><?php echo $item['quantity']; ?></td>
                    <td><?php echo $item['price'] * $item['quantity']; ?> E.G</td>
                </tr>
            <?php endforeach; ?>
        </table>

        <h2>Total: <?php echo $total_price; ?> E.G</h2>

        <form action="process_checkout.php" method="post">
            <button type="submit" class="checkout-btn">Confirm Purchase</button>
        </form>
    </div>
</body>
</html>
