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
    <title>RMU Form Online | Foreign Form Purchase</title>
    <style>
        .container {
            margin-top: 30px;
            margin-bottom: 30px;
        }

        .section-title {
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 20px;
            text-align: center;
        }

        .bank-details,
        .processing-fees {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 30px;
        }

        .bank-details h3,
        .processing-fees h3 {
            font-size: 1.25rem;
            margin-bottom: 15px;
        }

        .form-label {
            margin-top: 10px;
        }

        .btn-custom {
            background-color: #003262;
            color: #ffffff;
        }
    </style>
</head>

<body class="fluid-container">

    <div id="wrapper">

        <?php require_once("inc/page-nav.php"); ?>

        <div id="flashMessage" class="alert text-center" role="alert" style="display: none;"></div>

        <div class="container">

            <div class="text-center mb-4">
                <h1>Applying to RMU as a Non Member State Applicant</h1>
                <p>
                    To apply as a Non Member State student, please read our Non Member State Application Guidelines. Once you
                    have read the guidelines, please complete the form below to start your online admission process.
                </p>
            </div>

            <div class="row">

                <div class="col-md-6">

                    <!-- Non Member State Application Guidelines -->
                    <div class="section-title">Non Member State Application Guidelines</div>
                    <div class="mb-5">
                        <!-- Instructions go here -->
                        <p>
                            Please ensure you have all required documents ready, including academic transcripts, proof of
                            identification, and any other relevant materials. Follow the steps below to complete your application:
                        </p>
                        <ol>
                            <li>Fill the form with your accurate information.</li>
                            <li>Generate and copy your genrated Reference Number on Screen or sent to you via email and SMS.</li>
                            <li>Make the required payment using the provided bank details. Please quote your Name and Reference Number</li>
                            <li>Your form purchase request will be process within 24hrs of working days.</li>
                            <li>An Application Number and PIN will be generated and sent to you via email and SMS to start application process.</li>
                        </ol>
                    </div>

                    <!-- RMU FOREIGN BANK ACCOUNT DETAILS -->
                    <div class="bank-details">
                        <h3>RMU FOREIGN BANK ACCOUNT DETAILS</h3>
                        <p>
                            <strong>Bank Name:</strong> ECOBANK GH LTD<br>
                            <strong>Account Type:</strong> FOREIGN ACCOUNT<br>
                            <strong>Account Name:</strong> REGIONAL MARITIME UNIVERSITY<br>
                            <strong>Account Number:</strong> 2441000717754<br>
                            <strong>Currency:</strong> USD<br>
                            <strong>Branch:</strong> SPINTEX<br>
                            <strong>SWIFT Code:</strong> ECOCGHAC<br>
                            <strong>Sort Code:</strong> 130117<br>
                            <strong>Bank Address:</strong> SPINTEX ROAD PMB 19 SEVENTH AVE RIDE WEST, ACCRA, GHANA
                        </p>
                        <p>
                            You are requested to quote your Name and Reference Number (which is generated online - An Twelve(12)
                            Characters beginning with RMU-F....).
                        </p>
                    </div>

                    <!-- Processing Fees -->
                    <div class="processing-fees">
                        <h3>Processing Fees</h3>
                        <ul>
                            <?php
                            $forms = $expose->getAvailableForms();
                            if (!empty($forms)) {
                                foreach ($forms as $form) {
                            ?>
                                    <li><strong><?= $form['name'] ?>:</strong> $<?= $form['non_member_amount'] ?></li>
                            <?php
                                }
                            }
                            ?>
                        </ul>
                    </div>
                </div>

                <!-- Reference Number Request Form -->
                <div class="col-md-6">
                    <div class="form-card" style="border: 1px solid #003262; border-radius: 8px">

                        <div class="purchase-card-header mb-4">
                            <h1>Reference Number Request</h1>
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
                                <input type="hidden" name="state-type" value="non-member">
                            </form>
                        </div>
                    </div>

                </div>
            </div>

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
                            if (result.success) {
                                flashMessage("flashMessage", "alert-success", result.message);
                                window.location.href = result.message;
                            } else flashMessage("flashMessage", "alert-danger", result.message);
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