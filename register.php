<!DOCTYPE html>

<html lang="en">

<head>

    <title>Register</title>

    <link rel="stylesheet" type="text/css" href="css/style.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>

<body>
    <div class="form-container">

        <form action="register_process.php" method="post">

            <h2>Register</h2>

            <?php if (isset($_GET['error'])) { ?>

                <p class="error"><?php echo $_GET['error']; ?></p>

            <?php } ?>

            <input type="text" name="name" placeholder="Name" class="box"><br>

            <input type="text" name="username" placeholder="User Name" class="box"><br>

            <input type="number" name="phone" placeholder="Phone Number" class="box"><br>

            <input type="password" name="password" class="box"><br>

            <button type="submit" class="btn">Register</button>
            <p>already have an account? <a href="login.php">login now</a></p>

        </form>
    </div>
</body>

</html>