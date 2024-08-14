<?php
session_start();

require_once('bootstrap.php');

use Src\Controller\ExposeDataController;

$expose = new ExposeDataController();

if (empty($expose->getCurrentAdmissionPeriodID())) header("Location: close.php");

if (!isset($_SESSION["_purchaseToken"])) {
    $rstrong = true;
    $_SESSION["_purchaseToken"] = hash('sha256', bin2hex(openssl_random_pseudo_bytes(64, $rstrong)));
    $_SESSION["vendor_type"] = "ONLINE";
    $_SESSION["vendor_id"] = "1665605087";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once("inc/head-section.php"); ?>
    <title>Form Purchase | Step 1</title>
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


    <script src="js/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/country-list-with-dial-code-and-flag@latest/dist/main.js"></script>
    <script src="js/country.js"></script>
    <script>
        function flashMessage(el, bg_color, message) {
            const flashMessage = document.getElementById(el);
            flashMessage.classList.remove(...flashMessage.classList);
            flashMessage.classList.add("text-center");
            flashMessage.classList.add("alert");
            flashMessage.classList.add(bg_color);
            flashMessage.innerHTML = message;

            setTimeout(() => {
                flashMessage.style.display = "block";
                flashMessage.classList.add("show");
            }, 500);

            setTimeout(() => {
                flashMessage.classList.remove("show");
                setTimeout(() => {
                    flashMessage.style.display = "none";
                }, 500);
            }, 5000);
        }

        $(document).ready(function() {

            var triggeredBy = 0;

            $(".form-info").change("blur", function() {
                $("#form-cost-display").slideDown();
            });

            $("#purchaseForm").on("submit", function(e) {
                e.preventDefault();
                triggeredBy = 6;

                $.ajax({
                    type: "POST",
                    url: "endpoint/purchaseForm",
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(result) {
                        console.log(result);
                        // if (result.success) window.location.href = result.message;
                        // else flashMessage("flashMessage", "alert-danger", result.message);
                    },
                    error: function(error) {
                        console.log(error.statusText);
                    }
                });
            });

            $(document).on({
                ajaxStart: function() {
                    if (triggeredBy == 6) $("#submitBtn").prop("disabled", true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Processing...');
                },
                ajaxStop: function() {
                    if (triggeredBy == 6) $("#submitBtn").prop("disabled", false).html('Pay');
                }
            });
        });
    </script>
</body>

</html>