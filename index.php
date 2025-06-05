<?php
  ob_start();
  
  if (session_status()!==PHP_SESSION_ACTIVE)session_start();
  
  require 'config/func.php';
  include 'config/conn.php';
  
  if(!isset($_SESSION['role'])) {
    header("location: login.php");
    exit();
  }

  $id = $_SESSION["role"];
  $username = $_SESSION["username"];

  $sql_idx = "SELECT id_user, username_user FROM tbl_users WHERE id_user = '$id'";
  $query_idx = mysqli_query($conn, $sql_idx);
  $data_idx = mysqli_fetch_assoc($query_idx);

?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Dashboard - Expert System Workout</title>
        <?php
            include "assets/bootstrap-css.php";
        ?>
        <script src="node_modules/jquery/dist/jquery.min.js" type="text/javascript"></script>
    </head>
    <body>

    <?php
        include "src/components/navbar.php";
    ?>
    <!-- Content -->
    <div class="container-fluid p-4">
        <?php
            include "src/components/breadcrump.php";
        ?>
        <?php
        if(isset($_GET["page"])) {
            $modul  = $_GET["page"];
            if($_GET["page"] === "workoutguide") {
                if(file_exists("src/modul/workoutguide.php")) {
                    include "src/modul/workoutguide.php";
                  }
                  else {
                    include "src/components/error.php";
                  }
            }
            elseif ($_GET["page"] === "bodypart") {
              if(file_exists("src/modul/bodypart.php")) {
                  include "src/modul/bodypart.php";
                }
                else {
                  include "src/components/error.php";
                }
            }
            elseif ($_GET["page"] === "typeworkout") {
              if(file_exists("src/modul/typeworkout.php")) {
                  include "src/modul/typeworkout.php";
                }
                else {
                  include "src/components/error.php";
                }
            }
            else {
                if(file_exists("src/modul/home.php")) {
                    include "src/modul/home.php";
                }
                  else {
                    include "src/components/error.php";
                }
            }
        }
        else {
            if(file_exists("src/modul/home.php")) {
                include "src/modul/home.php";
            }
              else {
                include "src/components/error.php";
            }
        }
        ?>
    </div>
    <?php
        include "src/components/footer.php";
    ?>
    <?php
        include "assets/bootstrap-js.php";
    ?>
  </body>
</html>

<?php
  mysqli_close($conn);
  ob_end_flush();
?>