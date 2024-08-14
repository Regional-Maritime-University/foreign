DROP TABLE IF EXISTS `foreign_form_purchase_requests`;
CREATE TABLE `foreign_form_purchase_requests` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `reference_number` VARCHAR(12) UNIQUE NOT NULL,
    `first_name` VARCHAR(100) NOT NULL,
    `last_name` VARCHAR(100) NOT NULL,
    `email_address` VARCHAR(255) NOT NULL,
    `p_country_name` VARCHAR(100) NOT NULL,
    `p_country_code` VARCHAR(10) NOT NULL,
    `phone_number` VARCHAR(15) NOT NULL,
    `s_country_name` VARCHAR(100) NOT NULL,
    `s_country_code` VARCHAR(10) NOT NULL,
    `support_number` VARCHAR(15) NOT NULL,
    `form` INT,
    `admission_period` INT,
    `added_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT `fk_ffpr_form` FOREIGN KEY (`form`) REFERENCES `forms` (`id`) ON UPDATE CASCADE ON DELETE SET NULL,
    CONSTRAINT `fk_ffpr_admission_period` FOREIGN KEY (`admission_period`) REFERENCES `admission_period` (`id`) ON UPDATE CASCADE ON DELETE SET NULL
);