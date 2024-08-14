<?php
session_start();

require_once('bootstrap.php');

use Src\Controller\ExposeDataController;

$expose = new ExposeDataController();

if (empty($expose->getCurrentAdmissionPeriodID())) header("Location: close.php");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once("inc/head-section.php"); ?>
    <title>RMU Form Online | Foreign Form Purchase</title>
</head>

<body class="fluid-container">

    <div id="wrapper">

        <?php require_once("inc/page-nav.php"); ?>

        <div id="flashMessage" class="alert text-center" role="alert" style="display: none;"></div>

        <main class="container flex-container">
            <div class="flex-card">
                <p>Your Ref Number:
                <h1><?= $_SESSION["ref_number"] ?></h1>
                </p>
            </div>
        </main>

        <?php require_once("inc/page-footer.php"); ?>
    </div>
</body>

</html>