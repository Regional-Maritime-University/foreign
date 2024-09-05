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
    `app_number` VARCHAR(12), 
    `form` INT,
    `admission_period` INT,
    `added_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT `fk_ffpr_form` FOREIGN KEY (`form`) REFERENCES `forms` (`id`) ON UPDATE CASCADE ON DELETE SET NULL,
    CONSTRAINT `fk_ffpr_admission_period` FOREIGN KEY (`admission_period`) REFERENCES `admission_period` (`id`) ON UPDATE CASCADE ON DELETE SET NULL
);

CREATE INDEX idx_reference_number ON `foreign_form_purchase_requests` (`reference_number`);
CREATE INDEX idx_first_name ON `foreign_form_purchase_requests` (`first_name`);
CREATE INDEX idx_last_name ON `foreign_form_purchase_requests` (`last_name`);
CREATE INDEX idx_email_address ON `foreign_form_purchase_requests` (`email_address`);
CREATE INDEX idx_p_country_name ON `foreign_form_purchase_requests` (`p_country_name`);
CREATE INDEX idx_p_country_code ON `foreign_form_purchase_requests` (`p_country_code`);
CREATE INDEX idx_phone_number ON `foreign_form_purchase_requests` (`phone_number`);
CREATE INDEX idx_s_country_name ON `foreign_form_purchase_requests` (`s_country_name`);
CREATE INDEX idx_s_country_code ON `foreign_form_purchase_requests` (`s_country_code`);
CREATE INDEX idx_support_number ON `foreign_form_purchase_requests` (`support_number`);
CREATE INDEX idx_app_number ON `foreign_form_purchase_requests` (`app_number`);
CREATE INDEX idx_added_at ON `foreign_form_purchase_requests` (`added_at`);