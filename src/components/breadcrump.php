<?php
    if(isset($_GET["page"])) {
        $modul  = $_GET["page"];
        if($_GET["page"] === "workoutguide") { ?>
            <!-- Breadcrump -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="#"></a>Management Workout</li>
                    <li class="breadcrumb-item"><a href="index.php?page=<?= $modul; ?>">Workout Guide</a></li>
                </ol>
            </nav>
        <?php }
        elseif($_GET["page"] === "bodypart") { ?>
            <!-- Breadcrump -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="#"></a>Management Workout</li>
                    <li class="breadcrumb-item"><a href="index.php?page=<?= $modul; ?>">Body Part</a></li>
                </ol>
            </nav>
        <?php }
        elseif($_GET["page"] === "typeworkout") { ?>
            <!-- Breadcrump -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="#"></a>Management Workout</li>
                    <li class="breadcrumb-item"><a href="index.php?page=<?= $modul; ?>">Workout Type</a></li>
                </ol>
            </nav>
        <?php }
        elseif($_GET["page"] === "api") { ?>
            <!-- Breadcrump -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="index.php?page=<?= $modul; ?>">API</a></li>
                    <!-- <li class="breadcrumb-item"><a href="#">Library</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Data</li> -->
                </ol>
            </nav>
        <?php }
        else { ?>
            <!-- Breadcrump -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="index.php?page=<?= $modul; ?>">Home</a></li>
                </ol>
            </nav>
        <?php }
    }
    else { ?>
        <!-- Breadcrump -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php?page=<?= $modul; ?>">Home</a></li>
            </ol>
        </nav>
    <?php }
?>