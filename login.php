<!DOCTYPE html>

<html lang="en">

<head>

    <title>LOGIN</title>

    <link rel="stylesheet" type="text/css" href="css/style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

</head>

<body>
    <div class="form-container">

        <form action="login_process.php" method="post">

            <h2>LOGIN</h2>


            <?php
            if (isset($message)) {
                foreach ($message as $message) {
                    echo '<div class="message" onclick="this.remove();">' . $message . '</div>';
                }
            }
            ?>
            <input type="text" name="username" placeholder="User Name" value="" class="box"><br>


            <input type="password" name="password" placeholder="Password" value="" class="box"><br>

            <button type="submit" class="btn">Login</button>
            <p>don't have an account? <a href="register.php">register now</a></p>
        </form>
    </div>
</body>

</html>