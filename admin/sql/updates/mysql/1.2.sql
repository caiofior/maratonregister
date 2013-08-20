ALTER TABLE `#__atlete` CHANGE COLUMN `payment_type` `payment_type` ENUM('bank_transfer','money_order','paypal','other') NULL DEFAULT NULL COMMENT 'Payment type'  ;
