<?php

namespace Src\Controller;

use Src\System\DatabaseMethods;
use Src\Controller\ExposeDataController;

class VoucherPurchase
{
    private $expose;
    private $dm;

    public function __construct()
    {
        $this->expose = new ExposeDataController();
        $this->dm = new DatabaseMethods();
    }

    public function logActivity(int $user_id, $operation, $description)
    {
        $query = "INSERT INTO `activity_logs`(`user_id`, `operation`, `description`) VALUES (:u,:o,:d)";
        $params = array(":u" => $user_id, ":o" => $operation, ":d" => $description);
        $this->dm->inputData($query, $params);
    }

    private function genAppNumber(int $type, int $year)
    {
        $user_code = $this->expose->genCode(4);
        $number = ($type * 1000000) + ($year * 10000) + $user_code;
        return $number;
    }

    private function doesCodeExists($code)
    {
        $sql = "SELECT `id` FROM `foreign_form_purchase_requests` WHERE `id`=:p";
        if ($this->dm->getID($sql, array(':p' => sha1($code)))) {
            return 1;
        }
        return 0;
    }

    private function saveLoginDetails($reference_code, $data)
    {
        $sql = "INSERT INTO `foreign_form_purchase_requests` (`reference_number`, `first_name`, `last_name`, `email_address`, `p_country_name`, `p_country_code`, `phone_number`, `s_country_name`, `s_country_code`, `support_number`, `form`, `admission_period`) 
        VALUES(:rc, :fn, :ln, :ea, :pcn, :pcc, :pn, :scn, :scc, :sn, :f, :ap)";
        $params = [
            ':rc' => $reference_code,
            ':fn' => $data['first_name'],
            ':ln' => $data['last_name'],
            ':ea' => $data['email_address'],
            ':pcn' => $data['p_country_name'],
            ':pcc' => $data['p_country_code'],
            ':pn' => $data['phone_number'],
            ':scn' => $data['s_country_name'],
            ':scc' => $data['s_country_code'],
            ':sn' => $data['support_number'],
            ':f' => $data['form_id'],
            ':ap' => $data['adm_period']
        ];

        if ($this->dm->inputData($sql, $params)) {
            return ['success' => true, 'data' => $reference_code];
        }
        return ['success' => false, 'message' => 'Error occured while saving your data. Please try again later.'];
    }

    private function genLoginDetails(int $type, int $year)
    {
        $rslt = 1;
        while ($rslt) {
            $code = $this->genAppNumber($type, $year);
            $rslt = $this->doesCodeExists($code);
        }
        return 'RMU-F' . $code;
    }

    public function genLoginsAndSend(array $data)
    {
        $app_type = 0;

        if ($data["form_id"] >= 2) $app_type = 1;
        else if ($data["form_id"] == 1) $app_type = 2;

        $app_year = $this->expose->getAdminYearCode();
        $ref_code = $this->genLoginDetails($app_type, $app_year);
        $res = $this->saveLoginDetails($ref_code, $data);

        if ($res['success']) {
            $_SESSION['ref_number'] = $ref_code;
            $errors = [];

            if (!empty($data['phone_number'])) {
                $message = 'Your reference number is ' . $ref_code;
                $to = $data['p_country_code'] . $data['phone_number'];
                $response = json_decode($this->expose->sendSMS($to, $message));
                if ($response->status) $errors['sms'] = 'Failed to send your reference number via SMS';
            }

            if (!empty($data['email_address'])) {
                $emailMsg = '<p>Dear ' . $data['first_name'] . ' ' . $data['last_name'] . ', </p></br>';
                $emailMsg .= '<p>Your reference number is <strong style="font-size: 18px">' . $ref_code . '</strong></p>';
                $emailMsg .= '<p>Thank you for choosing Regional Maritime University.</p>';
                $emailMsg .= '<p>REGIONAL MARITIME UNIVERSITY</p>';
                $emailed = $this->expose->sendEmail($data['email_address'], 'Reference Number', $emailMsg);
                if (!$emailed['success']) $errors['email'] = 'Failed to send your reference number via Email';
            }

            $_SESSION['ref_num_sending_errors'] = $errors;
            return ['success' => true, 'message' => 'Data submitted successfully!'];
        } else {
            return array('success' => false, 'message' => 'Failed saving login details!');
        }
    }
}
