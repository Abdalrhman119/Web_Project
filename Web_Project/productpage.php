<?php
$product_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$pdo = new PDO('mysql:host=localhost;dbname=store_db', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$product_id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    echo "Product not found.";
    exit;
}

session_start();
$user_email = isset($_SESSION['user_email']) ? $_SESSION['user_email'] : null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $product['name']; ?> - Product Details</title>
    <link rel="stylesheet" href="styleProduct.css">
</head>
<body>
    <div class="container">
        <div class="product-details">
            <div class="product-image">
                <img src="<?php echo $product['image']; ?>" alt="Product Image">
            </div>
            <div class="product-info">
                <h1><?php echo $product['name']; ?></h1>
                <p class="price"><?php echo $product['price']; ?> E.G</p>
                <p class="description"><?php echo $product['description']; ?></p>

                <form action="add_to_cart.php" method="post">
                    <div class="cart-options">
                        <button class="quantity-btn" type="button" id="decrease">-</button>
                        <input type="number" name="quantity" value="1" class="quantity-input" min="1" id="quantity-input">
                        <button class="quantity-btn" type="button" id="increase">+</button>
                    </div>
                    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                    <input type="hidden" name="user_email" value="<?php echo $user_email; ?>">
                    <button type="submit" class="add-to-cart">ADD TO CART</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('increase').addEventListener('click', function() {
            var quantityInput = document.getElementById('quantity-input');
            quantityInput.value = parseInt(quantityInput.value) + 1;
        });

        document.getElementById('decrease').addEventListener('click', function() {
            var quantityInput = document.getElementById('quantity-input');
            if (parseInt(quantityInput.value) > 1) {
                quantityInput.value = parseInt(quantityInput.value) - 1;
            }
        });
    </script>
</body>
</html>
