<?php
session_start();

$user_email = isset($_SESSION['user_email']) ? $_SESSION['user_email'] : null;

if (!$user_email) {
    echo "You need to log in to view your cart.";
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
    <title>Your Cart</title>
    <link rel="stylesheet" href="Stylecart.css">
</head>
<body>
    <div class="container">
        <h1>Your Cart</h1>
        <table class="cart-table">
            <tr>
                <th>Product Name</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total</th>
                <th>Action</th>
            </tr>
            <?php foreach ($cart_items as $item): ?>
                <tr>
                    <td><?php echo $item['name']; ?></td>
                    <td><?php echo $item['price']; ?> E.G</td>
                    <td><?php echo $item['quantity']; ?></td>
                    <td><?php echo $item['price'] * $item['quantity']; ?> E.G</td>
                    <td>
                        <form action="remove_from_cart.php" method="post" style="display:inline;">
                            <input type="hidden" name="cart_item_id" value="<?php echo $item['id']; ?>">
                            <button type="submit" class="remove-btn">Remove</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>

        <div class="checkout">
            <form action="checkout.php" method="post">
                <button type="submit" class="checkout-btn">Checkout</button>
            </form>
        </div>
    </div>
</body>
</html>
