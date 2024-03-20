<?php

require_once "dbconfig.php";
session_start();
$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    header('location:login.php');
}

if (isset($_GET['logout'])) {
    unset($user_id);
    session_destroy();
    header('location:login.php');
}

if (isset($_POST['update_cart'])) {

    $cart_id = $_POST['cart_id'];
    $cart_quantity = $_POST['cart_quantity'];
    $update_cart =  $db->query("UPDATE  cart SET  quantity='$cart_quantity' WHERE id='$cart_id'");
    header('location:index.php');
}

if (isset($_POST['add_to_cart'])) {
    $product_name = $_POST['product_name'];
    $product_image = $_POST['product_image'];
    $product_quantity = $_POST['product_quantity'];
    $product_price = $_POST['product_price'];
    $product_id = $_POST['product_id'];


    $select_cart =  $db->query("SELECT * FROM cart WHERE product_id='$product_id' AND user_id='$user_id'");

    if ($select_cart->num_rows > 0) {
        $message[] = "Products Already in Cart";
    } else {
        $db->query("INSERT INTO cart ( user_id, name, price, image, product_id, quantity) VALUES ('$user_id' , '$product_name', '$product_price','$product_image' , '$product_id', '$product_quantity')");
        $message[] = "Products Added to Cart";
    }
}

if (isset($_GET['remove'])) {
    $cart_id = $_GET['remove'];
    $select_cart =  $db->query("DELETE FROM cart WHERE id='$cart_id' ");
    header('location:index.php');
}

if (isset($_GET['delete_all'])) {
    $db->query("DELETE FROM cart WHERE user_id='$user_id' ");
    header('location:index.php');
}

?>

<!DOCTYPE html>

<html lang="en">

<head>

    <title>Shopping Cart</title>

    <link rel="stylesheet" type="text/css" href="css/style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

</head>

<body>
    <div class="container">

        <div class="user-profile">
            <?php
            $select_user = $db->query("select * FROM users where id=$user_id");


            if (($select_user->num_rows > 0) == TRUE) {
                $row = $select_user->fetch_assoc();
            }
            ?>
            <p> username: <span><?php echo $row['username']; ?></span>
            <p> email: <span><?php echo $row['email']; ?></span>
            <div class="flex">
                <a href="login.php" class="btn">Login</a>
                <a href="register.php" class="option-btn">Register</a>
                <a href="index.php?logout=<?php echo $user_id; ?>" onclick="return confirm('Are you sure you want to Logout?')" class="delete-btn">Logout</a>

            </div>
        </div>
        <div class="products">
            <?php
            if (isset($message)) {
                foreach ($message as $messages) {
                    echo '<div class="message" onclick="this.remove();">' . $messages . '</div>';
                }
            }
            ?>

            <h1 class="heading">Latest Products</h1>
            <div class="box-container">
                <?php
                $select_product = $db->query("select * FROM products");
                if (($select_product->num_rows > 0) == TRUE) {
                    while ($fetch_product = $select_product->fetch_assoc()) {

                ?>
                        <form method="post" class="box" action="">
                            <img src="images/<?php echo $fetch_product['image']; ?>" alt="">
                            <div class="name"><?php echo $fetch_product['name']; ?></div>
                            <div class="price">$<?php echo $fetch_product['price']; ?></div>
                            <input type="number" name="product_quantity" min="1" value="1">
                            <input type="hidden" name="product_image" value="<?php echo $fetch_product['image']; ?>">
                            <input type="hidden" name="product_name" value="<?php echo $fetch_product['name']; ?>">
                            <input type="hidden" name="product_price" value="<?php echo $fetch_product['price']; ?>">
                            <input type="hidden" name="product_id" value="<?php echo $fetch_product['id']; ?>">
                            <input type="submit" value="Add to Cart" name="add_to_cart" class="btn">
                        </form>

                <?php                  }
                }
                ?>

            </div>

        </div>
        <div class="shopping-cart">
            <h1 class="heading">Shopping Cart<h1>
                    <table>
                        <thead>
                            <th>Images</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total Price</th>
                            <th>Action</th>

                        </thead>

                        <?php
                        $cart_query = $db->query("select * FROM cart where user_id='$user_id'");
                        $grand_total = 0;

                        if (($cart_query->num_rows > 0) == TRUE) {
                            while ($fetch_cart = $cart_query->fetch_assoc()) {
                                $cart_id = $fetch_cart['id'];
                        ?>
                                <tr>
                                    <td>
                                        <img src="images/<?php echo $fetch_cart['image'] ?>" height="100" alt="">
                                    </td>
                                    <td><?php echo $fetch_cart['name'] ?></td>
                                    <td>$<?php echo $fetch_cart['price'] ?></td>
                                    <td>
                                        <form action="" method="post">
                                            <input type="hidden" name="cart_id" value="<?php echo $fetch_cart['id']; ?>">
                                            <input type="number" min="1" name="cart_quantity" value="<?php echo $fetch_cart['quantity']; ?>">
                                            <input type="submit" name="update_cart" value="update" class="option-btn">
                                        </form>
                                    </td>

                                    <td>$<?php echo  $sub_total = number_format(floatval($fetch_cart['price']) * intval($fetch_cart['quantity']));  ?></td>
                                    <td><a href="index.php?remove=<?php echo $cart_id; ?>" class="delete-btn" onclick="return confirm('Remove item From Cart?')">Remove</td>
                                </tr>
                        <?php
                                $grand_total += $sub_total;
                            }
                        }
                        ?>
                        <tr class="table-bottom">
                            <td colspan="4">Grand Total : </td>
                            <td>$<?php echo $grand_total; ?></td>
                            <td><a href="index.php?delete_all" class="delete-btn" onclick="return confirm('Remove All Items From Cart?')"></a>Delete All</td>
                        </tr>
                    </table>
                    <div class="cart-btn">
                        <a href="#" class="btn <?php echo ($grand_total > 1) ? '' : 'disabled'; ?>">Proceed To Checkout</a>
                    </div>
        </div>
    </div>
</body>

</html>