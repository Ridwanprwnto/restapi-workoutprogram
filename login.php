<?php

ob_start();
if (session_status()!==PHP_SESSION_ACTIVE)session_start();

require 'config/func.php';
  include 'config/conn.php';

if(isset($_POST["login"])) {
    $user = mysqli_real_escape_string($conn, $_POST["user-name"]);
    $pass = mysqli_real_escape_string($conn, $_POST["user-password"]);
    $result = mysqli_query($conn, "SELECT * FROM tbl_users WHERE username_user = '$user'");
    if(mysqli_num_rows($result) === 1 ) {
        $rows = mysqli_fetch_assoc($result);
        if($rows["role_user"] === 'Admin' ) {
            if(password_verify($pass, $rows["password_user"])) {
                //Set Session
                $_SESSION["id"] = $rows['id_user'];
                $_SESSION["role"] = $rows['role_user'];
                $_SESSION["username"] = $rows['username_user'];
                $_SESSION["gender"] = $rows['gender_user'];

                header("location: index.php");
                exit();
            }
            else {
            ?>
                <script>
                    alert("Error: Password tidak sesuai");
                </script>
            <?php
            }
        }
        else {
        ?>
            <script>
                alert("Error: Role user tidak berhak login!");
            </script>
        <?php
        }
    }
    else {
    ?>
        <script>
            alert("Error: User tidak terdaftar!");
        </script>
    <?php
    }
}
  
?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Login - Expert System Workout</title>
        <?php
            include "assets/bootstrap-css.php";
            include "app-assets/layouting-css.php";
        ?>
    </head>
    <body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
            <form action="" method="post">
                <h2>Login</h2>
                <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" name="user-name" placeholder="Enter username">
                </div>
                <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" name="user-password" placeholder="Enter password">
                </div>
                <button type="submit" name="login" class="btn btn-dark">Login</button>
            </form>
            </div>
        </div>
    </div>
  </body>
</html>

<?php
  mysqli_close($conn);
  ob_end_flush();
?>