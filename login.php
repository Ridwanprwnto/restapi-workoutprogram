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
                $_SESSION["id"] = $rows['id_user'];
                $_SESSION["role"] = $rows['role_user'];
                $_SESSION["username"] = $rows['username_user'];
                $_SESSION["gender"] = $rows['gender_user'];
                header("location: index.php");
                exit();
            }
            else {
            ?>
                <script>alert("Error: Password tidak sesuai");</script>
            <?php
            }
        }
        else {
        ?>
            <script>alert("Error: Role user tidak berhak login!");</script>
        <?php
        }
    }
    else {
    ?>
        <script>alert("Error: User tidak terdaftar!");</script>
    <?php
    }
}

// Ambil data APK terbaru dari database
$apk_data = null;
$apk_query = mysqli_query($conn, "SELECT * FROM tbl_app ORDER BY id_app DESC LIMIT 1");
if ($apk_query && mysqli_num_rows($apk_query) > 0) {
    $apk_data = mysqli_fetch_assoc($apk_query);
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
        <style>
            html, body {
                height: 100%;
            }
            body {
                display: flex;
                flex-direction: column;
                min-height: 100vh;
            }
            .main-content {
                flex: 1;
                display: flex;
                justify-content: center;
                align-items: center;
            }
            .login-copyright {
                text-align: center;
                padding: 12px 0;
                font-size: 12px;
                color: #999;
                border-top: 1px solid #eee;
            }
        </style>
    </head>
    <body>

        <div class="main-content">
            <div class="col-md-4">

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

                <!-- APK Download Section -->
                <div class="apk-section">
                    <p>Download Aplikasi Android</p>

                    <?php if ($apk_data): ?>
                        <?php
                            $apk_file_path = 'app-assets/apk/' . $apk_data['filename_app'];
                            $file_exists   = file_exists($apk_file_path);
                        ?>
                        <?php if ($file_exists): ?>
                            <a href="<?= $apk_file_path ?>" class="btn-apk" download="<?= htmlspecialchars($apk_data['filename_app']) ?>">
                                Download APK
                            </a>
                        <?php else: ?>
                            <span class="btn-apk-disabled">File tidak ditemukan</span>
                        <?php endif; ?>
                        <small>
                            Versi <?= htmlspecialchars($apk_data['version_app']) ?>
                            &bull;
                            Android <?= htmlspecialchars($apk_data['min_android_app']) ?>+
                        </small>
                    <?php else: ?>
                        <span class="btn-apk-disabled">APK belum tersedia</span>
                        <small>Belum ada data APK</small>
                    <?php endif; ?>

                </div>

            </div>
        </div>

        <!-- Copyright -->
        <footer class="login-copyright">
            &copy; <?= date('Y') ?> Developed by
        <a class="text-secondary"  target="_blank" href="https://ridwanpurwanto-blog.vercel.app/">Ridwan Purwanto</a>
        </footer>

    </body>
</html>

<?php
    mysqli_close($conn);
    ob_end_flush();
?>