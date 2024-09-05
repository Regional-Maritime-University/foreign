<?php
session_start();
/*
* Designed and programmed by
* @Author: Francis A. Anlimah
*/

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require "../bootstrap.php";

use Src\Controller\ExposeDataController;

$expose = new ExposeDataController();

$data = [];
$errors = [];

if ($_SERVER['REQUEST_METHOD'] == "GET") {
    if ($_GET["url"] == "verifyStepFinal") {
        $arr = array();
        array_push($arr, $_SESSION["step1"], $_SESSION["step2"], $_SESSION["step4"], $_SESSION["step6"], $_SESSION["step7"]);
        echo json_encode($arr);
    }
}

// All POST request will be sent here
elseif ($_SERVER['REQUEST_METHOD'] == "POST") {
    if ($_GET["url"] == "purchaseForm") {
        if (!isset($_SESSION["_purchaseToken"]) || empty($_SESSION["_purchaseToken"]) || !isset($_POST["_vPToken"]) || empty($_POST["_vPToken"]) || $_POST["_vPToken"] != $_SESSION["_purchaseToken"])
            die(json_encode(array("success" => false, "message" => "Invalid request! Failed to process your request.")));

        if (!isset($_POST["first-name"]) || empty($_POST["first-name"]))
            die(json_encode(array("success" => false, "message" => "First Name required!")));
        if (!isset($_POST["last-name"]) || empty($_POST["last-name"]))
            die(json_encode(array("success" => false, "message" => "Last Name required!")));
        if (!isset($_POST["available-forms"]) || empty($_POST["available-forms"]))
            die(json_encode(array("success" => false, "message" => "Form type is required!")));
        if (!isset($_POST["email-address"]) || empty($_POST["email-address"]))
            die(json_encode(array("success" => false, "message" => "Email address is required!")));
        if (!isset($_POST["primary-country-code"]) || empty($_POST["primary-country-code"]))
            die(json_encode(array("success" => false, "message" => "Country code is required!")));
        if (!isset($_POST["support-country-code"]) || empty($_POST["support-country-code"]))
            die(json_encode(array("success" => false, "message" => "Country code is required!")));
        if (!isset($_POST["phone-number"]) || empty($_POST["phone-number"]))
            die(json_encode(array("success" => false, "message" => "Phone number is required!")));
        if (!isset($_POST["support-number"]) || empty($_POST["support-number"]))
            die(json_encode(array("success" => false, "message" => "Support phone number is required!")));
        if (!isset($_POST["state-type"]) || empty($_POST["state-type"]))
            die(json_encode(array("success" => false, "message" => "Member type is required!")));

        $primary_country = $expose->validateCountryCode($_POST["primary-country-code"]);
        $phone_number = $expose->validatePhone($_POST["phone-number"]);
        $support_country = $expose->validateCountryCode($_POST["support-country-code"]);
        $support_number = $expose->validatePhone($_POST["support-number"]);

        $primary_country_charPos = strpos($primary_country, ")");
        $primary_country_name = substr($primary_country, ($primary_country_charPos + 2));
        $primary_country_code = substr($primary_country, 1, ($primary_country_charPos - 1));

        $support_country_charPos = strpos($support_country, ")");
        $support_country_name = substr($support_country, ($support_country_charPos + 2));
        $support_country_code = substr($support_country, 1, ($support_country_charPos - 1));

        $payload = [];
        $payload["first_name"]         = $expose->validateInput($_POST["first-name"]);
        $payload["last_name"]          = $expose->validateInput($_POST["last-name"]);
        $payload["form_id"]            = $expose->validatePhone($_POST["available-forms"]);
        $payload["email_address"]      = $expose->validateEmail($_POST["email-address"]);
        $payload["p_country_name"]     = $primary_country_name;
        $payload["p_country_code"]     = $primary_country_code;
        $payload["phone_number"]       = $phone_number;
        $payload["s_country_name"]     = $support_country_name;
        $payload["s_country_code"]     = $support_country_code;
        $payload["support_number"]     = $support_number;
        $payload["state_type"]          = $_POST["state-type"];
        $payload["adm_period"]       = $expose->getCurrentAdmissionPeriodID();

        $data = $expose->processRequest($payload);
        die(json_encode($data));
    }
} else {
    http_response_code(405);
}
