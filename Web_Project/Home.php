<?php
$pdo = new PDO('mysql:host=localhost;dbname=store_db', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$stmt = $pdo->query("SELECT * FROM products");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

session_start();
$user_email = isset($_SESSION['user_email']) ? $_SESSION['user_email'] : null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products Page</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="StyleHome.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
<header class="d-flex justify-content-between align-items-center p-3 bg-light">
        <div class="logo">
            <i class="fa-solid fa-shop"></i> <span>Shop.com</span>
        </div>
        <div class="icons">
            <a href="login.php" class="icon-button text-dark">
                <i class="fa-solid fa-user"></i>
            </a>
            <a href="cart.php" class="icon-button text-dark">
                <i class="fa-solid fa-cart-shopping"></i>
            </a>
        </div>
    </header>

    <!-- Products Section -->
    <div class="container">
        <div class="row">
            <?php
            foreach ($products as $product) {
                echo "
                <div class='col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item women'>
                    <div class='block2'>
                        <div class='block2-pic hov-img0'>
                            <img src='{$product['image']}' alt='IMG-PRODUCT'>
                        </div>
                        <div class='block2-txt flex-w flex-t p-t-14'>
                            <div class='block2-txt-child1 flex-col-l '>
                                <a href='productpage.php?id={$product['id']}' class='stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6'>
                                    {$product['name']}
                                </a>
                                <span class='stext-105 cl3'>
                                    {$product['price']} E.G
                                </span>
                            </div>

                        </div>
                    </div>
                </div>";
            }
            ?>
        </div>
    </div>
</body>
</html>
