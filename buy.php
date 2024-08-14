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
                <div class="form-card" style="border: 1px solid #003262; border-radius: 8px">

                    <div class="purchase-card-header mb-4">
                        <h1>Code Generation Form</h1>
                    </div>

                    <div class="purchase-card-body">
                        <form id="purchaseForm" method="post" enctype="multipart/form-data">
                            <div class="mb-4">
                                <label class="form-label" for="first-name">First Name
                                    <span class="text-danger" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Required">*</span>
                                </label>
                                <input title="Provide your first name" class="form-control form-control-lg" type="text" name="first-name" id="first-name" placeholder="Type your first name" required>
                            </div>

                            <div class="mb-4">
                                <label class="form-label" for="last-name">Last Name
                                    <span class="text-danger" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Required">*</span>
                                </label>
                                <input style="width:100% !important" title="Provide your last name" class="form-control" type="text" name="last-name" id="last-name" placeholder="Type your last name" required>
                            </div>

                            <div class="mb-4">
                                <label class="form-label" for="email-address">Email Address
                                    <span class="text-danger" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Required">*</span>
                                </label>
                                <input title="Provide your email address" class="form-control" type="email" name="email-address" id="email-address" placeholder="example@company.com" required>
                            </div>

                            <div>
                                <label class="form-label" for="phone-number">Primary Phone Number
                                    <span class="text-danger" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Required">*</span>
                                </label>
                            </div>
                            <div class="mb-4 flex-row">
                                <div class="me-2" style="width: 45%">
                                    <select required name="primary-country-code" id="primary-country-code" title="Choose country" class="form-select form-control country-code">
                                    </select>
                                </div>
                                <div>
                                    <input required name="phone-number" id="phone-number" maxlength="12" title="Provide your Primary Phone Number" class="form-control" type="tel" placeholder="12345678901">
                                </div>
                            </div>

                            <div>
                                <label class="form-label" for="support-number">Support Phone Number
                                    <span class="text-danger" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Required">*</span>
                                </label>
                            </div>
                            <div class="mb-4 flex-row">
                                <div class="me-2" style="width: 45%">
                                    <select required name="support-country-code" id="support-country-code" title="Choose country" class="form-select form-control country-code">
                                    </select>
                                </div>
                                <div>
                                    <input required name="support-number" id="support-number" maxlength="12" title="Provide a Support Phone Number" class="form-control" type="tel" placeholder="12345678901">
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label" for="available-forms">Forms Type
                                    <span class="text-danger" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Required">*</span>
                                </label>
                                <select name="available-forms" id="available-forms" title="Select the type of form you want to purchase." class="form-select form-info" required>
                                    <option selected disabled value="">Choose...</option>
                                    <?php
                                    $data = $expose->getAvailableForms();
                                    foreach ($data as $fp) {
                                    ?>
                                        <option value="<?= $fp['id'] ?>"><?= $fp['name'] ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="mb-4" id="form-cost-display">
                                <input type="hidden" name="_vPToken" value="<?= $_SESSION["_purchaseToken"]; ?>">
                                <button class="btn btn-primary" type="submit" id="submitBtn" style="width:100%">Generate Code</button>

                            </div>
                        </form>
                    </div>
                </div>
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